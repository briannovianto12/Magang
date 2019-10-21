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
                $data = DB::table('shop_log_mutation')
                ->whereBetween('created_at', array($request->from_date, $request->to_date))
                ->get();
            }else{
                $data = DB::table('shop_log_mutation')
                ->get();
            }
            return datatables()->of($data)
            ->editColumn('mutation', function ($data) {
                
                return number_format($data->mutation, 0, 0, '.');
            })
            ->make(true);
        }
        return view('mutation::index');
    }
}
