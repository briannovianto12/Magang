<?php

namespace Bromo\Mutation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use DB;

class MutationController extends Controller
{
    function index(Request $request){
        if(request()->ajax()){
            if(!empty($request->from_date)){
                \Log::debug($request);
                $data = DB::table('shop_log_mutation')
                ->whereBetween('created_at', array($request->from_date, $request->to_date))
                ->get();
                \Log::debug($data);
            }else{
                $data = DB::table('shop_log_mutation')
                ->get();
            }
            \Log::debug($data);
            return datatables()->of($data)->make(true);
        }
        return view('mutation::index');
    }
}