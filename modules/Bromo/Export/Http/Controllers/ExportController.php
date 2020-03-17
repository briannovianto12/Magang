<?php

namespace Bromo\Export\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer as Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;
use DB;
use Carbon\Carbon;

class ExportController extends Controller
{
    protected $module;
    protected $title;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['module'] = $this->module;
        $data['title'] = $this->title;

        return view("export::index", $data);
    }

     /**
     * Get User 
     * @return Response
     */
    public function user()
    {
        return $request->user();
    }
    

    public function getExportOrderList(Request $request)
    {        
        $start = Carbon::now()->subDays(7);
        $end = Carbon::now();
        
        if(request()->ajax()){
            if(!empty($request->from_date) && !empty($request->to_date)){
                $start = Carbon::parse($request->from_date);
                $end = Carbon::parse($request->to_date);

                if($request->from_date == $request->to_date){
                    $start = Carbon::parse($request->from_date)->subDay();
                    $end = Carbon::parse($request->to_date);
                }
            }
        }

        return view('export::order_list', $data = [
            'start' => $start,
            'end' => $end
        ]);
        
    }

    private function exportOrderList($start, $end, $order_status, $payment_status) {
        $array_order_status = implode(",", $order_status);
        $array_payment_status = implode(",", $payment_status);
        $query = DB::select(DB::raw("
                SELECT order_no,
                    to_char(A.created_at,'YYYY-MM') as period,
                    to_char(A.created_at,'YYYY-MM-DD') as order_date,
                    buyer_snapshot->>'msisdn' as buyer_phone,
                    buyer_snapshot->>'full_name' as buyer_full_name,
                    business_snapshot->>'name' as buyer_business_name,
                    shop_snapshot->>'name' as seller_name,
                    payment_details->>'total_gross' as total_gross,
                    payment_details->>'platform_discount' as platform_discount,
                    shipping_service_snapshot->'shipper'->>'provider_key' as courier,
                    shipping_service_snapshot->'shipper'->>'rate_name' as courier_service,
                    shipping_service_snapshot->'shipper'->>'finalRate' as original_shipping_cost,
                    shipping_service_snapshot->'shipper'->>'insuranceRate' as original_insurance_rate,
                    shipping_service_snapshot->'shipper'->>'use_insurance' as use_insurance,
                    shipping_service_snapshot->'shipper'->>'platform_discount' as discount_shipping,
                    shipping_service_snapshot->'shipper'->>'shipping_cost' as final_shipping_cost,
                    payment_amount,
                    orig_address_snapshot->>'province' as origin_province,
                    orig_address_snapshot->>'city' as origin_city,
                    dest_address_snapshot->>'province' as destination_province,
                    dest_address_snapshot->>'city' as destination_city,
                    B.name as order_status,
                    C.name as payment_status
                    FROM order_trx A
                    JOIN order_status B ON A.status = B.id
                    JOIN payment_status C ON A.payment_status = C.id
                    WHERE to_char(A.created_at,'YYYY-MM-DD') BETWEEN ? AND ?
                    AND status IN ({$array_order_status})
                    AND payment_status IN ({$array_payment_status})
                    ORDER BY order_date ASC
            ")
        ,[$start, $end]);

            return $query;

    }

    public function export(Request $request){
        
        if($request->is('export/order-list/*')){
            $writer = $this->exportOrder($request);
            $fileName = "export-order-" . date("Y-m-d-H-i-s",time());
        }
        
        $response =  new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename='.$fileName.'.xlsx');
        $response->headers->set('Cache-Control','max-age=0');

        return $response;
    }

    public function exportOrder(Request $request){
        $start = Carbon::now()->subDays(7);
        $end = Carbon::now();

        $order_status = $request->all()['order_status'];
        $payment_status = $request->all()['payment_status'];
        
        if(request()->ajax()){
            if(!empty($request->from_date) && !empty($request->to_date)){
                $start = Carbon::parse($request->from_date);
                $end = Carbon::parse($request->to_date);

                if($request->from_date == $request->to_date){
                    $start = Carbon::parse($request->from_date)->subDay();
                    $end = Carbon::parse($request->to_date);
                }
            }
        }

        $data = $this->exportOrderList($start, $end, $order_status, $payment_status);

        $spreadsheet = new Spreadsheet();
        $speadsheet = $spreadsheet->getDefaultStyle()->getFont()->setName('Courier');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Order No.');
        $sheet->setCellValue('B1', 'Period');
        $sheet->setCellValue('C1', 'Order Date');
        $sheet->setCellValue('D1', 'Buyer Phone');
        $sheet->setCellValue('E1', 'Buyer Full Name');
        $sheet->setCellValue('F1', 'Buyer Business Name');
        $sheet->setCellValue('G1', 'Seller Name');
        $sheet->setCellValue('H1', 'Total Gross');
        $sheet->setCellValue('I1', 'Platform Discount');
        $sheet->setCellValue('J1', 'Courier');
        $sheet->setCellValue('K1', 'Courier Service');
        $sheet->setCellValue('L1', 'Origin Shipping Cost');
        $sheet->setCellValue('M1', 'Insurance Rate');
        $sheet->setCellValue('N1', 'Use Insurance');
        $sheet->setCellValue('O1', 'Discount Shipping');
        $sheet->setCellValue('P1', 'Final Shipping Cost');
        $sheet->setCellValue('Q1', 'Payment Amount');
        $sheet->setCellValue('R1', 'Origin Province');
        $sheet->setCellValue('S1', 'Origin City');
        $sheet->setCellValue('T1', 'Destination Province');
        $sheet->setCellValue('U1', 'Destination City');
        $sheet->setCellValue('V1', 'Order Status');
        $sheet->setCellValue('W1', 'Payment Status');
        $rows = 2;
        
        foreach($data as $data){
            $sheet->setCellValue('A' . $rows, $data->order_no);
            $sheet->setCellValue('B' . $rows, $data->period);
            $sheet->setCellValue('C' . $rows, $data->order_date);
            $sheet->setCellValue('D' . $rows, $data->buyer_phone);
            $sheet->setCellValue('E' . $rows, $data->buyer_full_name);
            $sheet->setCellValue('F' . $rows, $data->buyer_business_name);
            $sheet->setCellValue('G' . $rows, $data->seller_name);
            $sheet->setCellValue('H' . $rows, $data->total_gross);
            $sheet->setCellValue('I' . $rows, $data->platform_discount);
            $sheet->setCellValue('J' . $rows, $data->courier);
            $sheet->setCellValue('K' . $rows, $data->courier_service);
            $sheet->setCellValue('L' . $rows, $data->original_shipping_cost);
            $sheet->setCellValue('M' . $rows, $data->original_insurance_rate);
            $sheet->setCellValue('N' . $rows, $data->use_insurance);
            $sheet->setCellValue('O' . $rows, $data->discount_shipping);
            $sheet->setCellValue('P' . $rows, $data->final_shipping_cost);
            $sheet->setCellValue('Q' . $rows, $data->payment_amount);
            $sheet->setCellValue('R' . $rows, $data->origin_province);
            $sheet->setCellValue('S' . $rows, $data->origin_city);
            $sheet->setCellValue('T' . $rows, $data->destination_province);
            $sheet->setCellValue('U' . $rows, $data->destination_city);
            $sheet->setCellValue('V' . $rows, $data->order_status);
            $sheet->setCellValue('W' . $rows, $data->payment_status);
            $rows++;
        }

        return new Writer\Xlsx($spreadsheet);
    }
}
