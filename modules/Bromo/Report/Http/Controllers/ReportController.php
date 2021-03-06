<?php

namespace Bromo\Report\Http\Controllers;

use Bromo\Report\DataTables\ReportProductPublishedDatatable;
use Bromo\Report\Entities\ProductPublished;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer as Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;
use DB;
use Carbon\Carbon;

class ReportController extends Controller
{

    protected $module;
    protected $model;
    protected $title;


        /**
     * Create a new controller instance.
     *
     * @param Product $model
     */
    public function __construct(ProductPublished $model)
    {
        $this->model = $model;
        $this->module = 'report';
        $this->title = ucwords($this->module);
        $this->middleware('auth');
    }
    

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        // dd($this->model::all());
        $data['module'] = $this->module;
        $data['title'] = $this->title;

        return view("{$this->module}::index", $data);
    }

    /**
     * Get the submited data.
     *
     * @param ReportProductPublishedDatatable $datatable
     * @return mixed
     */
    public function productPublished(ReportProductPublishedDatatable $datatable)
    {
        return $datatable
            ->with([
                'model' => $this->model,
                'module' => $this->module,
            ])
            ->render("$this->module::list");
    }

    public function getStoreWithPublishedProduct() 
    {
        $data = DB::select('select * from vw_sellers_unverified');
        $data = $this->arrayPaginator($data, $request);
        return view('report::store',['data' => $data]);
    }

    public function getStoreRWithFewProduct(Request $request)
    {        
        $data['table'] = \DB::select("SELECT * FROM vw_store_with_published_product_less_than_ten");
        $data['table'] = $this->arrayPaginator($data['table'], $request);
        return view('report::shop_with_few_product', $data);
        
    }

    public function getStoreThatHasProduct(Request $request)
    {        
        $data['table'] = \DB::select("SELECT * FROM  vw_store_with_published_product");
        $data['table'] = $this->arrayPaginator($data['table'], $request);
        return view('report::shop_has_product', $data);
        
    }

    public function getProductOverHalfKilo(Request $request)
    {        
        $data['table'] = \DB::select("SELECT * FROM vw_product_w_with_more_than_half_a_kilo ORDER BY weight DESC");
        $data['table'] = $this->arrayPaginator($data['table'], $request);
        return view('report::product_weighing_more_than_half_kilo', $data);
        
    }

    public function getTotalBuyCount(Request $request)
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
            $data = $this->totalBuyQuery($start, $end);

            return datatables()->of($data)
            ->editColumn('total_gross', function ($data) {
                return '<div style="text-align:right">'.number_format($data->total_gross, 0, 0, '.').'</div>';
            })
            ->editColumn('count', function ($data) {
                return '<div style="text-align:right">'.$data->count.'</div>';
            })
            ->rawColumns(['total_gross', 'count'])
            ->make(true);
        }

        return view('report::total_buy_count', $data = [
            'start' => $start,
            'end' => $end
        ]);
        
    }

    private function totalBuyQuery($start, $end) {
        $query = DB::select(DB::raw("
                WITH summary as (
                    SELECT A.id, order_no, to_char(A.created_at,'YYYY-MM-DD') as order_date, 
                    business_id, B.name,
                    (A.payment_details->>'total_gross')::numeric as gross_amount
                    FROM order_trx A
                    INNER JOIN business B ON A.business_id = B.id
                    WHERE payment_status = 10
                    AND to_char(A.created_at,'YYYY-MM-DD') BETWEEN ? AND ?
                    ORDER BY to_char(A.created_at,'YYYY-MM-DD'), business_id
                ), summary_with_count AS ( 
                    SELECT 
                      x.business_id, 
                      name, 
                      COUNT(1), 
                      SUM(gross_amount) as total_gross
                      FROM summary x
                      GROUP BY x.business_id, name
                ), summary_with_address AS (
                    SELECT SWC.business_id, name, count, total_gross, BA.id as address_id, 
                    ROW_NUMBER() OVER (PARTITION BY SWC.business_id ORDER BY SWC.business_id)
                    FROM summary_with_count SWC JOIN business_address BA ON SWC.business_id = BA.business_id
                )
                SELECT X.business_id, name, count, total_gross,
                  Y.province, Y.city,
                  ZZ.full_name
                FROM summary_with_address X
                JOIN business_address Y ON X.address_id = Y.id
                JOIN business_member Z ON X.business_id = Z.business_id AND Z.role = 1 --Owner
                JOIN user_profile ZZ ON Z.user_id = ZZ.id
                WHERE row_number = 1;
            ")
        ,[$start, $end]);
    
            return $query;

    }

    public function getStoreWithActiveStatus(Request $request)
    {        
        $data['table'] = \DB::select("SELECT * FROM vw_store_with_active_status");
        $data['table'] = $this->arrayPaginator($data['table'], $request);
        return view('report::shop_with_active_status', $data);
        
    }

    public function arrayPaginator($array, $request){
        $page = Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;
        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
        ['path' => $request->url(), 'query' => $request->query()]);
    }

    public function export(Request $request){
        
        if($request->is('report/few-product/*')){
            $writer = $this->exportFewProduct();
            $fileName = "shopWithFewProduct";
        }
        else if($request->is('report/total-buy-count/*')){
            $writer = $this->exportTotalBuyCount($request);
            $fileName = "totalBuyCount";
        }
        else if($request->is('report/has_product/*')){
            $writer = $this->exportHasProduct();
            $fileName = "shopWithProduct";
        }
        else if($request->is('report/product-over-half-kilo/*')){
            $writer = $this->exportOverHalfKilo();
            $fileName = "productOverHalfKilo";
        }
        else if($request->is('report/active-status/*')){
            $writer = $this->exportActiveStatus();
            $fileName = "shopWithActiveStatus";
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

    public function exportTotalBuyCount(Request $request){
        $start = Carbon::now()->subDays(7);
        $end = Carbon::now();        

        if(!empty($request->query('from_date')) && !empty($request->query('to_date'))){
            $start = Carbon::parse($request->from_date);
            $end = Carbon::parse($request->to_date);
            if($request->from_date == $request->to_date){
                $start = Carbon::parse($request->from_date)->subDay();
                $end = Carbon::parse($request->to_date);
            }
        }

        $data = $this->totalBuyQuery($start, $end);
        
        $spreadsheet = new Spreadsheet();
        $speadsheet = $spreadsheet->getDefaultStyle()->getFont()->setName('Courier');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Shop Name');
        $sheet->setCellValue('B1', 'Total Bought Product');
        $sheet->setCellValue('C1', 'Total Gross');
        // $sheet->setCellValue('G1', 'Order Date');
        $rows = 2;
        
        foreach($data as $data){
            $sheet->setCellValue('A' . $rows, $data->name);
            $sheet->setCellValue('B' . $rows, $data->count);
            $sheet->setCellValue('C' . $rows, $data->total_gross);
            // $sheet->setCellValue('G' . $rows, $data->order_date);
            $rows++;
        }

        return new Writer\Xlsx($spreadsheet);
    }

    private function exportFewProduct(){
        $data = \DB::select("SELECT * FROM vw_store_with_published_product_less_than_ten");
        $spreadsheet = new Spreadsheet();
        $speadsheet = $spreadsheet->getDefaultStyle()->getFont()->setName('Courier');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Shop Name');
        $sheet->setCellValue('B1', 'Full Name');
        $sheet->setCellValue('C1', 'Phone');
        $sheet->setCellValue('D1', 'Address');
        $sheet->setCellValue('E1', 'Total Published Product');
        $rows = 2;
        
        foreach($data as $data){
            $sheet->setCellValue('A' . $rows, $data->shop_name);
            $sheet->setCellValue('B' . $rows, $data->full_name);
            $sheet->setCellValue('C' . $rows, $data->msisdn);
            $sheet->setCellValue('D' . $rows, $data->address_line);
            $sheet->setCellValue('E' . $rows, $data->count);
            $rows++;
        }

        return new Writer\Xlsx($spreadsheet);
    }

    private function exportOverHalfKilo(){
        $data = \DB::select("SELECT * FROM vw_product_w_with_more_than_half_a_kilo");
        $spreadsheet = new Spreadsheet();
        $speadsheet = $spreadsheet->getDefaultStyle()->getFont()->setName('Courier');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Product ID');
        $sheet->setCellValue('B1', 'Product Name');
        $sheet->setCellValue('C1', 'Weight');
        $sheet->setCellValue('D1', 'Shop ID');
        $sheet->setCellValue('E1', 'Shop Name');
        $sheet->setCellValue('F1', 'Address');
        $sheet->setCellValue('G1', 'Owner Name');
        $sheet->setCellValue('H1', 'Owner Phone Number');
        $rows = 2;
        
        foreach($data as $data){
            $sheet->setCellValueExplicit('A' . $rows, intval($data->product_id), DataType::TYPE_STRING);
            $sheet->setCellValue('B' . $rows, $data->product_name);
            $sheet->setCellValue('C' . $rows, $data->weight);
            $sheet->setCellValue('D' . $rows, $data->shop_id);
            $sheet->setCellValue('E' . $rows, $data->shop_name);
            $sheet->setCellValue('F' . $rows, $data->address);
            $sheet->setCellValue('G' . $rows, $data->owner_name);
            $sheet->setCellValue('H' . $rows, $data->owner_phone_number);
            $rows++;
        }

        return new Writer\Xlsx($spreadsheet);
    }

    private function exportHasProduct(){
        $data = \DB::select("SELECT * FROM vw_store_with_published_product");
        $spreadsheet = new Spreadsheet();
        $speadsheet = $spreadsheet->getDefaultStyle()->getFont()->setName('Courier');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Shop Name');
        $sheet->setCellValue('B1', 'Full Name');
        $sheet->setCellValue('C1', 'Phone');
        $sheet->setCellValue('D1', 'Address');
        $sheet->setCellValue('E1', 'Total Published Product');
        $rows = 2;
        
        foreach($data as $data){
            $sheet->setCellValue('A' . $rows, $data->shop_name);
            $sheet->setCellValue('B' . $rows, $data->full_name);
            $sheet->setCellValue('C' . $rows, $data->msisdn);
            $sheet->setCellValue('D' . $rows, $data->address_line);
            $sheet->setCellValue('E' . $rows, $data->count);
            $rows++;
        }

        return new Writer\Xlsx($spreadsheet);
    }

    private function exportActiveStatus(){
        $data = \DB::select("SELECT * FROM vw_store_with_active_status");
        $spreadsheet = new Spreadsheet();
        $speadsheet = $spreadsheet->getDefaultStyle()->getFont()->setName('Courier');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Shop Name');
        $sheet->setCellValue('B1', 'Full Name');
        $sheet->setCellValue('C1', 'Phone');
        $sheet->setCellValue('D1', 'Address');
        $sheet->setCellValue('E1', 'Province');
        $sheet->setCellValue('F1', 'City');
        $rows = 2;
        
        foreach($data as $data){
            $sheet->setCellValue('A' . $rows, $data->shop_name);
            $sheet->setCellValue('B' . $rows, $data->full_name);
            $sheet->setCellValue('C' . $rows, $data->msisdn);
            $sheet->setCellValue('D' . $rows, $data->address_line);
            $sheet->setCellValue('E' . $rows, $data->province);
            $sheet->setCellValue('F' . $rows, $data->city);
            $rows++;
        }

        return new Writer\Xlsx($spreadsheet);
    }
}
