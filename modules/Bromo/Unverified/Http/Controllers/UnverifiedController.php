<?php

namespace Bromo\Unverified\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer as Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use DB;


class UnverifiedController extends Controller{
    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function index(Request $request){
        $data = DB::select('select * from vw_sellers_unverified');
        $data = $this->arrayPaginator($data, $request);
        return view('unverified::index',['data' => $data]);
    }

    public function export(){
        $data = DB::select('select * from vw_sellers_unverified');
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Shop Name');
        $sheet->setCellValue('B1', 'Description');
        $sheet->setCellValue('C1', 'Building Name');
        $sheet->setCellValue('D1', 'Address Line');
        $sheet->setCellValue('E1', 'MSISDN');
        $rows = 2;

        foreach($data as $data){
            $sheet->setCellValue('A' . $rows, $data->shop_name);
            $sheet->setCellValue('B' . $rows, $data->description);
            $sheet->setCellValue('C' . $rows, $data->building_name);
            $sheet->setCellValue('D' . $rows, $data->address_line);
            $sheet->setCellValue('E' . $rows, $data->msisdn);
            $rows++;
        }

        $writer = new Writer\Xlsx($spreadsheet);

        $response =  new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="ExportScan.xls"');
        $response->headers->set('Cache-Control','max-age=0');

        return $response;
    }

    public function arrayPaginator($array, $request){
        $page = Input::get('page', 1);
        $perPage = 2;
        $offset = ($page * $perPage) - $perPage;
        return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
        ['path' => $request->url(), 'query' => $request->query()]);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}