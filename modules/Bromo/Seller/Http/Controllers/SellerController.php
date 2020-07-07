<?php

namespace Bromo\Seller\Http\Controllers;

use Bromo\Auth\Models\Admin;
use Bromo\Buyer\Models\Buyer;
use Bromo\Buyer\Models\BusinessBankAccount;
use Bromo\HostToHost\Traits\Result;
use Bromo\Seller\DataTables\SellerDataTable;
use Bromo\Seller\Models\Shop;
use Bromo\Seller\Models\ShopRegistrationLog;
use Bromo\Seller\Models\ShopStatus;
use Bromo\Seller\Entities\BankAccountLogs;
use Bromo\Seller\Entities\BankAccount;
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
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Writer as Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Bromo\Seller\Entities\Business;
use Bromo\Seller\Entities\BusinessAddress;
use Illuminate\Support\Collection;

use Bromo\Seller\Entities\Product;
use Bromo\Seller\Entities\CourierMapping;
use Bromo\Seller\Entities\ShippingCourier;
use Bromo\Seller\Entities\CommissionGroup;
use Carbon\Carbon;
use Carbon\CarbonImmutable;



class SellerController extends BaseResourceController
{
    use Result;

    private const TAX_IMAGE = 'business/tax-image/FILENAME';
    private const DEFAULT_NO_IMAGE = 'https://via.placeholder.com/320x320?text=No+Image';

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
            $sheet->setCellValueExplicit('A' . $rows, intval($data->amount), DataType::TYPE_STRING);
            $sheet->setCellValue('B' . $rows, $data->bank_code);
            $sheet->setCellValue('C' . $rows, $data->bank_account_name);
            $sheet->setCellValueExplicit('D' . $rows, $data->bank_account_number, DataType::TYPE_STRING)->getStyle('D');
            $sheet->setCellValueExplicit('D' . $rows, $data->bank_account_number, DataType::TYPE_STRING)->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('E' . $rows, $data->description);
            $sheet->setCellValue('F' . $rows, $data->email);
            $sheet->setCellValue('G' . $rows, $data->email_cc);
            $sheet->setCellValue('H' . $rows, $data->email_bcc);
            $sheet->setCellValue('I' . $rows, $data->external_id, DataType::TYPE_STRING);
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
        $response->headers->set('Content-Disposition', 'attachment;filename="sellerwithbalance.xlsx"');
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

    public function show($id)
    {
        $this->pageData['data'] = $this->model->findOrFail($id);
        $businessBankAccount = BusinessBankAccount::where('business_id', $this->pageData['data']->business_id)->get();
        $owner = $this->pageData['data']->business->getOwner();
        $this->requiredData = [
            'owner' => $owner,
            'business_bank_account' => $businessBankAccount
        ];
        $data = array_merge($this->pageData, $this->requiredData);
        $response = $this->getTaxImageURL($data['data']->tax_card_image_file);
        $data['data']['tax_image_private_url'] = $response;

        $data['data']['courier_list'] = $this->courierMapping($this->pageData['data']->business_id);

        return view($this->getDetailView(), $data);
    }

    public function verifyBankAccount($bank_account)
    {
        // dd($bank_account);
        DB::beginTransaction();
        try {
            $bank_account = BankAccount::findOrFail($bank_account);

            $latestUpdateLog = BankAccountLogs::query()
                ->where('business_id', $bank_account->business_id)
                ->orderBy('created_at', 'desc')
                ->first();

            $bank_account_logs = New BankAccountLogs;
                $bank_account_logs->bank_account_id = $bank_account->bank_id;
                $bank_account_logs->business_bank_account_id = $bank_account->id;
                $bank_account_logs->business_id = $bank_account->business_id;
                $bank_account_logs->account_no = $bank_account->account_no;
                $bank_account_logs->account_owner_name = $bank_account->account_owner_name;
                $bank_account_logs->bank_id = $bank_account->bank_id;
                $bank_account_logs->bank_name = $bank_account->bank_name;
                $bank_account_logs->is_default = $bank_account->is_default;
                $bank_account_logs->is_verified = True;
                $bank_account_logs->modified_by = auth()->user()->id;
                $bank_account_logs->modifier_role = Admin::ADMIN;
            $bank_account_logs->save();

            BankAccount::where('id', '=', $bank_account->id)
            ->update([
                'is_verified' => True
                ]
            );

            DB::commit();

            return response()->json('OK', Response::HTTP_OK);

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

    private function getTaxImageURL($filename)
    {
        if ($filename == null) {
            $response = self::DEFAULT_NO_IMAGE;

            return $response;
        } else {
            try {
                $endpoint = config('hosttohost.api') . str_replace('FILENAME', $filename, self::TAX_IMAGE);
                $header = [
                    'Authorization' => config('hosttohost.admin_token'),
                ];

                $service = new RequestService();
                $response = $service->setUrl($endpoint)
                    ->setHeaders($header)
                    ->get();

                if ($response->getStatusCode() !== Response::HTTP_OK) {
                    $error = $response->original;
                    $decode = json_decode($error['body']);

                    throw new Exception($decode->message, $decode->code);
                } else {
                    $content = $response->original;
                    $response = json_decode($content['body']);
                    $response = current($response->data);
                }
            } catch (\Exception $exception) {
                report($exception);

                $response = new Response();
                $response->setStatusCode(400);
                \Log::error(json_decode($exception->getMessage()));
            }
            if($response == "") {
                $response = self::DEFAULT_NO_IMAGE;
            }
            return $response;
        }
    }
    public function shopDescription(Request $request, $id){
        $shop_description = $request->get('description');
        DB::beginTransaction();
        try{
            $shop = $this->model::find($id);
            $shop->description = $shop_description;
            $shop->save();

            $business = Business::find($shop->business_id);
            $business->description = $shop_description;
            $business->save();

            DB::commit();

            nbs_helper()->flashMessage('stored');
        } catch (Exception $exception) {
            report($exception);
            DB::rollBack();

            nbs_helper()->flashMessage('error');
        }
        return redirect()->back();

    }

    public function status($id)
    {
        DB::beginTransaction();
        try {
            $shop = Shop::findOrFail($id);
            $products = Product::where('shop_id', $id)->get();
            $shop->update([
                'status' => ($shop->status === ShopStatus::SUSPENDED) ? ShopStatus::VERIFIED : ShopStatus::SUSPENDED
            ]);

            foreach($products as $product){
                $product->update([
                    'status' => ($shop->status === ShopStatus::SUSPENDED) ? \Bromo\Product\Models\ProductStatus::UNPUBLISH : \Bromo\Product\Models\ProductStatus::PUBLISH
                ]);
            }

            DB::commit();
            nbs_helper()->flashMessage('stored');

        } catch (Exception $exception) {
            report($exception);
            DB::rollBack();

            nbs_helper()->flashMessage('error');
        }

        return redirect()->back();
    }

    public function getBusinessAddress($id)
    {
        $shop = $this->model::find($id);
        $shop_business_address_list = BusinessAddress::where('business_id', $shop->business_id)->get();

        foreach ($shop_business_address_list as $address) {
            if ($shop->address_id == $address->id) {
                $address['current_address'] = true;
            }

            $address['id_str'] = strval($address->id);
        }

        return response()->json([
            'shop' => $shop,
            'shop_business_address_list' => $shop_business_address_list
        ]);
    }

    public function postBusinessAddress(Request $request, $id)
    {
        try {
            $new_pickup_address = $request->input('addressId');

            $shop = $this->model::find($id);
            $shop->update([
                'address_id' => $new_pickup_address
            ]);

            return response()->json([
                "status" => "OK"
            ]);
        } catch (Exception $exception) {
            report($exception);

            return response()->json([
                "status" => "Failed"
            ]);
        }
    }

    public function getCommissionInfo($id)
    {
        $shop = $this->model::find($id);
        $commission_group = CommissionGroup::all();

        foreach ($commission_group as $commission) {
            if ($shop->commissionType['id'] == null ) {
                $shop['current_commission_null'] = true;
            } else if ($commission->id == $shop->commissionType['id'] ) {
                $commission['current_commission'] = true;
            }
        }

        return response()->json([
            'shop' => $shop,
            'commission_group' => $commission_group
        ]);
    }

    public function postCommission(Request $request, $id)
    {
        try {
            $new_commission_type = $request->input('commissionId');
            $shop = $this->model::find($id);
            $resp = '';

            if ($new_commission_type == null) {
                return;
                }

            if ($new_commission_type == CommissionGroup::STANDARD) {
                $standard = DB::select("SELECT public.f_update_commission_standard_and_check($shop->id)");
            } elseif ($new_commission_type == CommissionGroup::PREMIUM) {
                $premium = DB::select("SELECT public.f_update_commission_premium_and_check($shop->id)");
            }

            return response()->json([
                "status" => "OK"
            ]);
        } catch (Exception $exception) {
            report($exception);

            return response()->json([
                "status" => "Failed"
            ]);
        }

        return redirect()->back();
    }

    public function temporaryClosed(Request $request, $id){
        $temporary_closed_message = $request->get('temporary_closed_message');
        try{
            $shop = $this->model::find($id);
            $shop->temporary_closed_message = $temporary_closed_message;
            $shop->is_temporary_closed = 1;
            $shop->save();

            nbs_helper()->flashMessage('stored');

        } catch (Exception $exception) {
            report($exception);

            nbs_helper()->flashMessage('error');
        }
        return redirect()->back();
    }

    public function reOpenShop($id){
        try{
            $shop = $this->model::find($id);
            $shop->temporary_closed_message = '';
            $shop->is_temporary_closed = 0;
            $shop->save();

            nbs_helper()->flashMessage('stored');

        } catch (Exception $exception) {
            report($exception);

            nbs_helper()->flashMessage('error');
        }
        return redirect()->back();
    }


    private function courierMapping($business_id){
        $courier_list = CourierMapping::where('seller_business_id', $business_id)->get();

        return $courier_list;
    }

    public function getShippingCourier($id)
    {
        $shop = $this->model::find($id);
        $couriers = ShippingCourier::all();
        $seller_courier = CourierMapping::where('seller_business_id', $shop->business_id)->get();

        foreach ($couriers as $courier) {
            foreach ($seller_courier as $seller) {
                if ($seller->courier_id == $courier->id) {
                    $courier['checked'] = true;
                }
            }
        }

        return response()->json([
            'shop' => $shop,
            'couriers' => $couriers,
            'seller_courier' => $seller_courier,
        ]);
    }

    public function postShippingCourier(Request $request, $id)
    {
        $new_couriers = $request->input('couriers');
        $old_couriers = [];

        $shop = $this->model::find($id);
        $business_id = $shop->business_id;
        $courier_mappings = CourierMapping::where('seller_business_id', $shop->business_id)->get();

        foreach($courier_mappings as $courier) {
            array_push($old_couriers, $courier->courier_id);
        }

        $delete_couriers = array_diff($old_couriers, $new_couriers);
        $insert_couriers = array_diff($new_couriers, $old_couriers);

        DB::beginTransaction();
        try{
            if($insert_couriers){
                $data_set = [];

                foreach($insert_couriers as $courier) {
                    $data_set[] = [
                        'seller_business_id' => $shop->business_id,
                        'courier_id' => $courier,
                        'remark' => 'test input local aditya',
                        'created_at' => Carbon::now()->format('Y-m-d H:m:s.uP'),
                        'updated_at' => Carbon::now()->format('Y-m-d H:m:s.uP'),
                    ];
                }
                CourierMapping::insert($data_set);
            }

            if($delete_couriers){
                CourierMapping::whereIn('courier_id', $delete_couriers)->where('seller_business_id', $shop->business_id)->delete();
            }

            DB::commit();

            return response()->json([
                "status" => "OK"
            ]);
        }catch(Exception $exception){
            DB::rollback();
            report($exception);

            return response()->json([
                "status" => "Failed"
            ]);

        }
    }
}
