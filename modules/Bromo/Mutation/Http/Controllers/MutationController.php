<?php

namespace Bromo\Mutation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

use DB;

class MutationController extends Controller
{
     /**
     * Get User 
     * @return Response
     */
    public function user()
    {
        return $request->user();
    }
    
    function index(Request $request){
        $start = Carbon::now()->subDays(7);
        $end = Carbon::now();

        if(request()->ajax()){
            if(!empty($request->from_date) && !empty($request->to_date)){
                $start = Carbon::parse($request->from_date);
                $end = Carbon::parse($request->to_date);
            }
            $data = DB::table('shop_log_mutation')
                ->join('shop','shop_log_mutation.shop_id', 'shop.id')
                ->join('business','business.id', 'shop.business_id')
                ->join('business_member','business.id', 'business_member.business_id')
                ->join('user_profile','user_profile.id', 'business_member.user_id')
                ->whereBetween('shop_log_mutation.created_at', array($start, $end->addDay()))
                ->select('shop_log_mutation.id', 'shop_log_mutation.shop_id', 'shop_log_mutation.mutation',
                        'shop_log_mutation.remark', 'shop_log_mutation.trx_type', 'shop_log_mutation.created_at',
                        'shop_log_mutation.updated_at', 'shop.name', 'user_profile.full_name')
                ->get();
            return datatables()->of($data)
            ->editColumn('shop_name', function ($data) {
                return $data->name;
            })
            ->editColumn('owner_name', function ($data) {
                return $data->full_name;
            })
            ->editColumn('mutation', function ($data) {
                return '<div style="text-align:right">'.number_format($data->mutation, 0, 0, '.').'</div>';
            })
            ->editColumn('created_at', function ($data) {
                return date("Y-m-d H:i:s", strtotime($data->created_at));
            })
            ->rawColumns(['mutation'])
            ->make(true);
        }

        return view('mutation::index',
        $data = [
            'start' => $start,
            'end' => $end
        ]);
    }
}
