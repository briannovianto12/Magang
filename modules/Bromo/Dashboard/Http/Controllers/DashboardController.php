<?php

namespace Bromo\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {        
        $data['title'] = 'Dashbor';
        $data['breadcrumbs'] = [
           [ "name" => "Dashbor", "url" => route('dashboard') ]
        ];
        $data['summary'] = $this->getSummary();
        return view('dashboard::index', $data);
        
    }

    private function getSummary(){
        $totalRegistratedSeller = DB::select("SELECT public.f_get_total_seller()");
        $totalRegistratedUser = DB::select("SELECT public.f_get_total_user()");
        $totalRegistratedSellerWithProduct = DB::select("SELECT public.f_get_sellers_with_total_product()");
        
        return [
            'total_registrated_seller' => $totalRegistratedSeller[0]->f_get_total_seller,
            'total_registrated_user' => $totalRegistratedUser[0]->f_get_total_user,
            'total_registrated_seller_with_product' => $totalRegistratedSellerWithProduct[0]->f_get_sellers_with_total_product,
        ];


    }
}