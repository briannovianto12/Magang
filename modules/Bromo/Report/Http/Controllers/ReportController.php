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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer as Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;
use DB;


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
        $data['table'] = \DB::select("SELECT * FROM vw_product_w_with_more_than_half_a_kilo");
        $data['table'] = $this->arrayPaginator($data['table'], $request);
        return view('report::product_weighing_more_than_half_kilo', $data);
        
    }

    public function getTotalBuyCount(Request $request)
    {        
        $data['table'] = \DB::select("SELECT * FROM vw_buyer_totalbuy_count");
        $data['table'] = $this->arrayPaginator($data['table'], $request);
        return view('report::total_buy_count', $data);
        
    }

    public function arrayPaginator($array, $request){
        $page = Input::get('page', 1);
        $perPage = 25;
        $offset = ($page * $perPage) - $perPage;
        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
        ['path' => $request->url(), 'query' => $request->query()]);
    }

    public function export(){
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

        $writer = new Writer\Xlsx($spreadsheet);

        $response =  new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="shopwithfewproduct.xls"');
        $response->headers->set('Cache-Control','max-age=0');

        return $response;
    }

    public function exportTotalBuyCount(){
        $data = \DB::select("SELECT * FROM vw_buyer_totalbuy_count");
        $spreadsheet = new Spreadsheet();
        $speadsheet = $spreadsheet->getDefaultStyle()->getFont()->setName('Courier');
        $sheet = $spreadsheet->getActiveSheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Shop Name');
        $sheet->setCellValue('B1', 'Total Bought Product');
        $sheet->setCellValue('C1', 'Full Name');
        $sheet->setCellValue('D1', 'Province');
        $sheet->setCellValue('E1', 'City');
        $rows = 2;
        
        foreach($data as $data){
            $sheet->setCellValue('A' . $rows, $data->name);
            $sheet->setCellValue('B' . $rows, $data->count);
            $sheet->setCellValue('C' . $rows, $data->full_name);
            $sheet->setCellValue('D' . $rows, $data->province);
            $sheet->setCellValue('E' . $rows, $data->city);
            $rows++;
        }

        $writer = new Writer\Xlsx($spreadsheet);

        $response =  new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="totalbuycount.xls"');
        $response->headers->set('Cache-Control','max-age=0');

        return $response;
    }

}
