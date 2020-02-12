<?php

namespace Bromo\Mutation\Http\Controllers;

use Bromo\HostToHost\Traits\Result;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Bromo\Mutation\Entities\Shop;
use Carbon\Carbon;

use Modules\Bromo\HostToHost\Services\RequestService;

class PaymentController extends Controller
{
    use Result;

    private $auth_key;
    private $base_url;
    private $httpClient;

    private const PAYMENT_DETAIL = 'sellers/web/cashin';
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if(request()->ajax()){
            $data = Shop::select(
                    'shop.id as id',
                    'shop.name as name', 
                    'user_profile.full_name as full_name',
                    'user_profile.msisdn as msisdn'
                )
                ->join('business_member', 'shop.business_id','=', 'business_member.business_id')
                ->join('user_profile', 'business_member.user_id', '=', 'user_profile.id');
            return datatables()->of($data)
            ->addColumn('link', function ($data) {
                return '<a href="' . route('mutation.payment-detail-view', ['id' => $data->id]) .'">'.'Payment Detail'.'</a>';
            })
            ->rawColumns(['link'])
            ->make(true);
        }
        return view('mutation::payment-detail');
    }

    public function getPaymentDetail($shop_id, Request $request) 
    {
        $data['current_month'] = Carbon::now();
        $data['month'] = Carbon::now()->month;
        $data['year'] = Carbon::now()->year;

        if($request->get('month'))
        {
            $data['month'] = $request->get('month');
        }

        if($request->get('year'))
        {
            $data['year'] = $request->get('year');
        }
        
        $start_month = Carbon::now()->startOfMonth()->month($data['month'])->timestamp;
        $end_month = Carbon::now()->endOfMonth()->month($data['month'])->timestamp;

        if($data['year'] > 0){
            $start_month = Carbon::now()->startOfMonth()->month($data['month'])->year($data['year'])->timestamp;
            $end_month = Carbon::now()->endOfMonth()->month($data['month'])->year($data['year'])->timestamp;
        }

        $data['current_year'] = Carbon::now()->year;
        $data['begin'] = $data['current_year'] - 20;
        $data['end'] = $data['current_year'];
        $data['name'] = 'select year';

        $shop = Shop::where('id', $shop_id)->first();
        $data['shop_id'] = intval($shop->id);
        $shop_name = $shop->name;
        
        $response = $this->cashIn($data['shop_id'], $start_month, $end_month);
        // dd($response);
        $response = $response->original['body'];
        $response = json_decode($response, true);

        $data['response'] = $response['data'];
        
        $data['shop'] = $shop_name;

        return view('mutation::payment-detail-view', $data);
        
    }

    private function cashIn($shop_id, $start_month, $end_month)
    {
        try {
            $endpoint = config('hosttohost.api') . self::PAYMENT_DETAIL . "?start_date=$start_month&end_date=$end_month&shop_id=$shop_id";
            $header = [
                'Authorization' => config('hosttohost.seller_token'),
            ];

            $service = new RequestService();
            $response = $service->setUrl($endpoint)
                ->setHeaders($header)
                ->get();

            if ($response->getStatusCode() !== Response::HTTP_OK) {
                $error = $response->original;
                $decode = json_decode($error['body']);

                throw new Exception($decode->message, $decode->code);
            }

        } catch (\Exception $exception) {
            report($exception);

            $response = new Response();
            $response->setStatusCode(400);
            \Log::error(json_decode($exception->getMessage()));
            
            nbs_helper()->flashError($exception->getMessage() ?? 'Something wen\'t wrong. Please contact Administrator');
        }

        return $response;
    }

}
