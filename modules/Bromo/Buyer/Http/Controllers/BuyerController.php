<?php

namespace Bromo\Buyer\Http\Controllers;

use Illuminate\Routing\Controller;

class BuyerController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['title'] = 'Buyer';

        return view('buyer::index', $data);
    }
}
