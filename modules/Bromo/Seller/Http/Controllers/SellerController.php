<?php

namespace Bromo\Seller\Http\Controllers;

use Illuminate\Routing\Controller;

class SellerController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        $data['title'] = 'Seller';

        return view('seller::index', $data);
    }
}
