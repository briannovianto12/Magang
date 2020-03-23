<?php

namespace Bromo\Disbursement\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Bromo\Disbursement\DataTables\DisbursementHeaderDataTable;
use Bromo\Disbursement\DataTables\DisbursementItemDataTable;
use Bromo\Disbursement\Entities\DisbursementHeader;
use Bromo\Disbursement\Entities\DisbursementItem;
use Bromo\Disbursement\Entities\ViewSellerBalance;
use Bromo\Disbursement\Entities\SellerBalance;
use Modules\Bromo\HostToHost\Services\RequestService;
use Bromo\HostToHost\Traits\Result;

use Exception;
use Illuminate\Support\Facades\DB;
use Carbon;
use DateInterval;


class DisbursementController extends Controller
{
    use Result;

    protected $module;
    protected $modelHeader;
    protected $modelItem;
    protected $title;

    private const PROCESS_DISBURSEMENT = 'admin/batch-disbursement/DISBURSEMENT_HEADER_ID';

    public function __construct(DisbursementHeader $modelHeader, DisbursementItem $modelItem)
    {
        $this->modelHeader = $modelHeader;
        $this->modelItem = $modelItem;
        $this->module = 'disbursement';
        $this->title = ucwords($this->module);
        $this->middleware('auth');

        $this->base_url = config('disbursement.api');
        $this->auth_key = config('disbursement.auth_key');
    }

    public function index()
    {
        $data['module'] = $this->module;
        $data['title'] = $this->title;

        return view("{$this->module}::list-header", $data);
    }

    public function indexItem($header_id)
    {
        $data['module'] = $this->module;
        $data['title'] = $this->title;

        $disbursement_header = DisbursementHeader::where('id', '=', $header_id)->first();
        $data['header_no'] = $disbursement_header->disbursement_header_no;
        $data['header_id'] = $header_id;
        $data['status'] = $disbursement_header->status; 

        return view("{$this->module}::list-item", $data);
    }

    public function dataTableHeader(DisbursementHeaderDatatable $datatable)
    {
        return $datatable
            ->with([
                'model' => $this->modelHeader,
                'module' => $this->module,
            ])
            ->render("$this->module::list-header");
    }

    public function dataTableItem(DisbursementItemDataTable $datatable, $header_id)
    {
        return $datatable
            ->with([
                'model' => $this->modelItem,
                'module' => $this->module,
                'header_id' => $header_id,
            ])
            ->render("$this->module::list-item");
    }

    public function createDisbursement(Request $request) {
        DB::beginTransaction();
        try {
            $count_saved = 0;
            $count_not_saved = 0;
            $last_current_balance_update = "";

            $year = Carbon\Carbon::now()->year;
            $user = auth()->user();

            $sellerBalance = ViewSellerBalance::all();
            
            $sumAmount = 0;
            $countItem = count($sellerBalance);
            
            $shopCurrentBalance = SellerBalance::where('balance', '>', 0)->orderBy('updated_at', 'desc')->first();
            $lastHeaderUpdate = DisbursementHeader::latest()->first();
            
            if($lastHeaderUpdate){
                $last_current_balance_update = $lastHeaderUpdate->last_current_balance_update;
            } else {
                $date = date('Y-m-d H:i:sO', strtotime('-2 seconds', strtotime($shopCurrentBalance->updated_at)));
                $last_current_balance_update = $date;
            }
            

            // dd($last_current_balance_update);
            
            $header_no = DB::select("SELECT f_gen_autonum('D$year', 'PROCESS_DISB') as header_id")[0]->header_id;

            // Begin process disbursement
            if($shopCurrentBalance->updated_at > $last_current_balance_update) {
                // Create New Header
                $disbursementHeader = New DisbursementHeader;
                $disbursementHeader->disbursement_header_no = $header_no;
                $disbursementHeader->amount = $count_saved;
                $disbursementHeader->total_item = $sumAmount;
                $disbursementHeader->remark = $request->input('remark');
                $disbursementHeader->created_by = $user->id;
                $disbursementHeader->last_current_balance_update = $shopCurrentBalance->updated_at;
                $disbursementHeader->save();
            
                // Loop through available item (seller current balance)
                for($i=0; $i < $countItem; $i++) {
                    $disbursementItem = New DisbursementItem;
                    $existing_record = DisbursementHeader::selectRaw("process_disbursement_item.external_id, sum(process_disbursement_item.amount) as amount")
                            ->join('process_disbursement_item', 'process_disbursement_item.disbursement_header_id', '=','process_disbursement_header.id')
                            ->where('external_id', '=', $sellerBalance[$i]['external_id'])
                            ->where('processed_flag', '=', false)->groupBy("process_disbursement_item.external_id")->first();
                    
                    if($existing_record) {
                        $disbursementItem->amount = $sellerBalance[$i]['amount'] - $existing_record->amount;
                    } else {
                        $disbursementItem->amount = $sellerBalance[$i]['amount'];
                    }
                    $disbursementItem->bank_code = $sellerBalance[$i]['bank_code'];
                    $disbursementItem->bank_account_name = $sellerBalance[$i]['bank_account_name']; 
                    $disbursementItem->bank_account_number = $sellerBalance[$i]['bank_account_number'];
                    $disbursementItem->description = $sellerBalance[$i]['description']; 
                    $disbursementItem->email = $sellerBalance[$i]['email']; 
                    $disbursementItem->email_cc = $sellerBalance[$i]['email_cc']; 
                    $disbursementItem->email_bcc = $sellerBalance[$i]['email_bcc']; 
                    $disbursementItem->external_id = $sellerBalance[$i]['external_id']; 
                    $disbursementItem->shop_name = $sellerBalance[$i]['shop_name']; 
                        
                    if($disbursementItem->amount != 0) {
                        $disbursementItem->disbursement_header_id = $disbursementHeader->id;
                        $disbursementItem->save();
                        $count_saved +=  1;
                        $sumAmount += $disbursementItem->amount;                                   
                    } else {
                        $count_not_saved += 1; 
                    }                
                }
                // Update header with total item and sum amount
                $header = DisbursementHeader::find($disbursementHeader->id);
                $header->update([
                    'total_item' => $count_saved,
                    'amount' => $sumAmount,
                ]);
            }
            DB::commit();
            if($count_saved > 0) {
                return response()->json([
                        "status" => "OK",
                        "header_no" => $header_no,
                        "saved" => $count_saved,
                        "duplicated" => $count_not_saved
                    ]);
            } else {
                return response()->json([
                        "status" => "FAILED",
                        "saved" => $count_saved,
                        "duplicated" => $count_not_saved
                    ]);
            }
                            
        } catch(Exception $exception) {
            DB::rollback();

            report($exception);

                return response()->json([
                    "status" => "ERROR"
                ]);

        }
        return redirect()->route($this->module . '.index');
    }

    public function processDisbursement($header_id) 
    {
        try {
            $endpoint = $this->base_url . str_replace('DISBURSEMENT_HEADER_ID', $header_id, self::PROCESS_DISBURSEMENT);
            $header = [
                'Content-Type' => 'application/json',
                'Authorization' => $this->auth_key,
            ];
            \Log::debug($endpoint);
            \Log::debug($this->auth_key);

            $service = new RequestService();
            $response = $service->setUrl($endpoint)
                ->setHeaders($header)
                ->post();

            $original = $response->original;
            $original = json_decode($original['body']);
            $response = $original->data;

            if ( $response->error_code != '' ) {

                return response()->json([
                    "status" => 'FAILED',
                    "disbursement" => $response->status,
                    "reference" => '',
                    "error_code" => $response->error_code,
                    "message" => $response->message,
                ]);
            }

            return response()->json([
                "status" => 'OK',
                "disbursement" => $response->status,
                "reference" => $response->reference,
                "error_code" => '',
                "message" => '',
            ]);

        } catch (\Exception $exception) {
            report($exception);

            $response = new Response();
            $response->setStatusCode(400);
            \Log::error(json_decode($exception->getMessage()));
            
            return response()->json([
                "status" => "Error",
                "disbursement" => '',
                "reference" => '',
                "error_code" => '',
                "message" => '',
            ]);
        }
    }
}