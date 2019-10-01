<?php

namespace Bromo\Seller\Http\Controllers;

use Bromo\Auth\Models\Admin;
use Bromo\Buyer\Models\Buyer;
use Bromo\HostToHost\Traits\Result;
use Bromo\Seller\DataTables\SellerDataTable;
use Bromo\Seller\Models\Shop;
use Bromo\Seller\Models\ShopRegistrationLog;
use Bromo\Seller\Models\ShopStatus;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Bromo\HostToHost\Services\RequestService;
use Nbs\BaseResource\Http\Controllers\BaseResourceController;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer as Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SellerController extends BaseResourceController
{
    use Result;
    public function __construct(Shop $model, SellerDataTable $dataTable)
    {
        $this->module = 'store';
        $this->page = 'Store';
        $this->title = 'Store';
        $this->model = $model;
        $this->dataTable = $dataTable;
        $this->validateStoreRules = [
            'name' => [
                'required'
            ],
            'description' => [
                'required'
            ]
        ];
        $this->validateUpdateRules = [
            'name' => [
                'required'
            ],
            'description' => [
                'required'
            ]
        ];

        parent::__construct();
    }

    public function verify($id)
    {
        DB::beginTransaction();
        try {
            $shop = $this->approval($id, ShopStatus::VERIFIED);

            $latestRegistrationLog = ShopRegistrationLog::query()
                ->where('shop_id', $shop->id)
                ->orderBy('updated_at', 'desc')
                ->first();

            ShopRegistrationLog::create([
                'shop_id' => $id,
                'shop_snapshot' => null,
                'status' => ShopStatus::VERIFIED,
                'notes' => '',
                'modified_by' => auth()->user()->id,
                'modifier_role' => Admin::ADMIN,
                'version' => ($latestRegistrationLog->version ?? 0) + 1
            ]);

            //Send notification
            $owner = $shop->business->getOwner();

            if (!is_null($owner)) { // check owner is exist

                $token = $owner->getNotificationTokens();
                if (count($token) > 0) { // check token is exists
                    firebase()
                        ->toAndroid($owner->id, 'BSM002', [
                            "title" => "Approved",
                            "message" => "Your Shop has been Approved"
                        ])
                        ->setTokens($token->toArray())
                        ->sendToDevice();
                }
            }

            $data = [
                'user_id' => $owner->id ?? null,
                'user_name' => $owner->full_name ?? null,
                'business_id' => $owner->business->id ?? null,
                'business_name' => $owner->business->name ?? null,
                'shop_id' => $shop->id ?? null,
                'shop_name' => $shop->name ?? null,
                'shop_status' => $shop->status
            ];

            DB::commit();

            return response()->json($data, Response::HTTP_OK);

        } catch (Exception $exception) {
            report($exception);
            DB::rollBack();
            if ($exception->getCode() == Response::HTTP_BAD_REQUEST) {
                return response()->json([
                    'message' => $exception->getMessage()
                ], $exception->getCode());
            }

            return response()->json([
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function reject(Request $request, $id)
    {
        $this->validate($request, [
            'notes' => 'required|max:256'
        ]);

        DB::beginTransaction();
        try {
            $shop = $this->model->findOrFail($id);
            $owner = $shop->business->getOwner();

            $shop->update([
                'status' => ShopStatus::REJECTED
            ]);
            $shop->statusNotes()->create([
                'shop_snapshot' => $shop->getOriginal(),
                'status' => ShopStatus::REJECTED,
                'notes' => $request->input('notes')
            ]);
            $latestRegistrationLog = ShopRegistrationLog::query()
                ->where('shop_id', $shop->id)
                ->orderBy('updated_at', 'desc')
                ->first();

            $decodeData = json_decode($latestRegistrationLog['shop_snapshot'], true);

            $snapshot = [
                'changes' => [],
                'data' => $decodeData['data'] ?? $decodeData
            ];

            ShopRegistrationLog::create([
                'shop_id' => $id,
                'shop_snapshot' => $snapshot,
                'status' => ShopStatus::REJECTED,
                'notes' => $request->input('notes'),
                'modified_by' => auth()->user()->id,
                'modifier_role' => Admin::ADMIN,
                'version' => ($latestRegistrationLog->version ?? 0) + 1
            ]);

            if (!is_null($owner)) { // check owner is exist
                $token = $owner->getNotificationTokens();
                if (count($token) > 0) { // check token is exists
                    // Send notification
                    firebase()
                        ->toAndroid($owner->id, 'BSM002', [
                            "title" => "Rejected",
                            "message" => "Your Shop has been Rejected"
                        ])
                        ->setTokens($token->toArray())
                        ->sendToDevice();
                }
            }

            $data = [
                'shop' => $shop,
                'shop_status' => 'Rejected'
            ];

            DB::commit();
            return response()->json($data, Response::HTTP_OK);

        } catch (Exception $exception) {
            report($exception);
            DB::rollBack();

            return response()->json([
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $id
     * @param int $status
     * @return Model
     * @throws Exception
     */
    public function approval($id, int $status)
    {
        $data = $this->model->find($id);

        if (is_null($data->business->getOwner())) {
            throw new Exception("The Shop doesn't have members", Response::HTTP_BAD_REQUEST);
        }

        $data->update([
            'status' => $status
        ]);

        return $data;
    }

    public function requestJwt(Request $request)
    {
        try {
            $userId = $request->input('user_id');

            $user = Buyer::findOrFail($userId);

            $qiscusToken = $this->getJwt($user->id);

            $data = [
                'token' => $qiscusToken ?? '',
                'app_id' => config('hosttohost.chat.app_id'),
                'shop_status' => 'Verified'
            ];

            return response()->json($data, Response::HTTP_OK);

        } catch (\Exception $exception) {
            report($exception);

            return response()->json([
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get jwt token.
     *
     * @return string
     */
    private function getJwt($id): string
    {
        $nonce = $this->getNonce();
        $endpoint = config('hosttohost.api') .
            "/business/sellers/chats/tokens/{$nonce}?user_id={$id}";

        $service = new RequestService();
        $headers = [
            'Authorization' => config('hosttohost.chat.token'),
        ];

        $response = $service->setUrl($endpoint)
            ->setHeaders($headers)
            ->get();

        $result = $this->response($response);
        $content = $result->getContent();
        $data = json_decode($content, true);

        return $data['data']['token'];
    }

    /**
     * Get nonce.
     *
     * @return string
     */
    private function getNonce(): string
    {
        $endpoint = 'https://api.qiscus.com/api/v2/sdk/auth/nonce';
        $service = new RequestService();
        $headers = [
            'qiscus_sdk_app_id' => config('hosttohost.chat.app_id'),
        ];

        $response = $service->setUrl($endpoint)
            ->setHeaders($headers)
            ->post();

        $result = $this->response($response);
        $content = $result->getContent();
        $data = json_decode($content, true);
        $this->nonce = $data['data']['results']['nonce'];

        return $data['data']['results']['nonce'];
    }

    
    /**
     * @param $id
     * @param int $status
     * @return Model
     * @throws Exception
     */
    public function getBalanceView(Request $request)
    {
        $data = \DB::select("SELECT * FROM vw_seller_balance_xendit_template");
        $data = $this->arrayPaginator($data, $request);
        return view('store::balance',['data' => $data]);
    }

    public function export(){
        $data = \DB::select("SELECT * FROM vw_seller_balance_xendit_template");
        $spreadsheet = new Spreadsheet();
        $speadsheet = $spreadsheet->getDefaultStyle()->getFont()->setName('Courier');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Amount');
        $sheet->setCellValue('B1', 'Bank Code');
        $sheet->setCellValue('C1', 'Bank Account Name');
        $sheet->setCellValue('D1', 'Bank Account Number');
        $sheet->setCellValue('E1', 'Description');
        $sheet->setCellValue('F1', 'Email');
        $sheet->setCellValue('G1', 'Email CC ');
        $sheet->setCellValue('H1', 'Email BCC');
        $sheet->setCellValue('I1', 'External Id');
        $sheet->setCellValue('J1', 'Shop Name');
        $rows = 2;

        foreach($data as $data){
            $sheet->setCellValue('A' . $rows, $data->amount);
            $sheet->setCellValue('B' . $rows, $data->bank_code);
            $sheet->setCellValue('C' . $rows, $data->bank_account_name);
            $sheet->setCellValue('D' . $rows, $data->bank_account_number)->getStyle('D')->getNumberFormat();
            $sheet->setCellValue('D' . $rows, $data->bank_account_number)->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('E' . $rows, $data->description);
            $sheet->setCellValue('F' . $rows, $data->email);
            $sheet->setCellValue('G' . $rows, $data->email_cc);
            $sheet->setCellValue('H' . $rows, $data->email_bcc);
            $sheet->setCellValue('I' . $rows, $data->external_id);
            $sheet->setCellValue('J' . $rows, $data->shop_name);
            $rows++;
        }

        $writer = new Writer\Xlsx($spreadsheet);

        $response =  new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="sellerwithbalance.xls"');
        $response->headers->set('Cache-Control','max-age=0');

        return $response;
    }

    public function arrayPaginator($array, $request){
        $page = Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;
        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
        ['path' => $request->url(), 'query' => $request->query()]);
    }
}
