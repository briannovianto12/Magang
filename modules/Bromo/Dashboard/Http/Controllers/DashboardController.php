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
        $totalRegisteredSeller = DB::select("SELECT public.f_get_total_seller()");
        $totalRegisteredUser = DB::select("SELECT public.f_get_total_user()");
        $totalRegisteredSellerWithProduct = DB::select("SELECT public.f_get_sellers_with_total_product()");
        
        return [
            'total_registered_seller' => $totalRegisteredSeller[0]->f_get_total_seller,
            'total_registered_user' => $totalRegisteredUser[0]->f_get_total_user,
            'total_registered_seller_with_product' => $totalRegisteredSellerWithProduct[0]->f_get_sellers_with_total_product,
        ];


    }
}