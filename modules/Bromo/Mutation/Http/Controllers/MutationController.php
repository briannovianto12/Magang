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
                ->join('shop','shop_log_mutation.shop_id', 'shop.id')
                ->whereBetween('created_at', array($request->from_date, $request->to_date))
                ->select('shop_log_mutation.*', 'shop.name')
                ->get();
                \Log::debug($data);
            }else{
                $data = DB::table('shop_log_mutation')
                ->join('shop','shop_log_mutation.shop_id', 'shop.id')
                ->join('business','business.id', 'shop.business_id')
                ->join('business_member','business.id', 'business_member.business_id')
                ->join('user_profile','user_profile.id', 'business_member.user_id')
                ->where('business_member.role', '1')
                ->select('shop_log_mutation.*', 'shop.name', 'user_profile.full_name')
                ->get();
            }
            \Log::debug($data);
            return datatables()->of($data)->make(true);
        }
        return view('mutation::index');
    }
}
