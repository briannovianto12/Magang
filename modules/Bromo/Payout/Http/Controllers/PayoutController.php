<?php

namespace Bromo\Payout\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Bromo\Payout\Entities\Payout;
use Bromo\Payout\Entities\PayoutReason;
use Bromo\Payout\Entities\UserProfile;
use Bromo\Payout\Entities\PayoutApprover;
use Bromo\Auth\Models\Admin;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

use DataTables;
use Log;
use Carbon\Carbon;
use Redirect;

class PayoutController extends Controller
{
    private const VOID_PAYOUT = 'admin/payout/void';
    private const SEND_LINK = "admin/payout/PAYOUT_ID/sms";
    private const CREATE_PAYOUT = 'admin/payout';


    public function __construct()
    {
        $this->module = 'payout';
        $this->page = 'Payout';
        $this->title = 'Payout';

        $this->httpClient = new Client();
        $this->base_url = config('payout.api');
        $this->auth_key = config('payout.auth_key');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('payout::index');
    }

    public function form(){
        $reason = PayoutReason::all();

        return view('payout::form', ['reason' => $reason]);
    }

    public function create(Request $request)
    {   
        try{
            $request->validate([
                'amount' => 'required',
                'reason' => 'required',
                'additional_notes' => 'required',
                'created_for' => 'required|exists:user_profile,msisdn',
            ]);
    
            $reason = PayoutReason::where('id', $request->reason)->first();
            $created_by = auth()->user()->id;
            $user = UserProfile::where('msisdn', $request->created_for)->first();
            $created_for = $user->id;
            
            $amount = str_replace(".", "", $request->amount);
            $amount = intval($amount); 
    
            $params = [
                'amount' => $amount,
                'reason_id' => $reason->id,
                'reason' => $reason->reason,
                'additional_notes' => $request->additional_notes,
                'created_by' => $created_by,
                'created_for' => $created_for
            ];
    
            $endPointUrl = self::CREATE_PAYOUT;

            $data = $this->requestAPI($params, $endPointUrl);

            return Redirect::to('payout');

        } catch (Exception $exception) {
            report($exception);
        }
        return redirect()->back()->with(['error' => json_encode($exception->getMessage(), true)]);
    }

    public function getData(Request $request)
    {
        $data = Payout::select(
            'id', 'internal_no','created_for_user_id', 'created_by', 'amount', 
            'created_at', 'reason', 'additional_notes', 'status', 'is_approved', 'expired_at'
            )->orderBy('created_at', 'desc')->get(); 

        return datatables()->of($data)
        ->editColumn('created_for_user_id', function ($data) {
            return $data->userProfile->full_name;
        })
        ->editColumn('created_by', function ($data) {
            return $data->admin->name;
        })
        ->editColumn('amount', function ($data) {
            $amount = $data->amount;
            return number_format($amount, 0, 0, '.');
        })
        ->editColumn('created_at', function ($data) {
            return date('d-m-Y h:i', strtotime($data->created_at));
        })
        ->editColumn('expired_at', function ($data) {
            return date('d-m-Y h:i', strtotime($data->expired_at));
        })
        ->addColumn('action', function ($data) {
            $payoutApprover = $this->payoutApprover();

            if ( $data->is_approved == false ) {
                $action = [
                    'waiting_approval' => 'Waiting for Approval'
                ];

                if (isset($payoutApprover['approver']) && $data->is_approved == false) {
                    $action = array('approve' => ( route("$this->module.approve", $data->id)) );
                }
            } else {
                $action = [
                    'void' => route("$this->module.void", $data->id),
                    'send_link' => route("$this->module.send-link", $data->id),
                ];
            }
            
            if ($data->status != 'ISSUED') {
                $action = [];
            }

            return view('theme::layouts.includes.actions', $action);
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function void($id) 
    {
        $payout = Payout::select(
            'id', 'created_by', 'reason', 'expired_at'
            )->where('id', $id)->first();
        $params = [
            "id" => $payout->id,
	        "created_by" => $payout->created_by,
	        "reason" => $payout->reason,
        ];

        $expiry_date = $payout->expired_at;

        if ($expiry_date <= Carbon::now()) {
            \Log::debug('Payout Expired');
            return response()->json([
                "status" => "Failed",
                "message" => "Can Not Void Payout. Link Expired!"
            ]);
        };

        $endPointUrl = self::VOID_PAYOUT;
        $data = $this->requestAPI($params, $endPointUrl);

        return response()->json([
            "status" => "OK",
            "message" => "Success Void Link!"
        ]);
    }

    public function sendLink($id) 
    {
        $payout = Payout::select(
            'id', 'expired_at', 'is_approved'
            )->where('id', $id)->first();

        $expiry_date = $payout->expired_at;
        
        if ($expiry_date <= Carbon::now()) {
            \Log::debug('Payout Expired');
            return response()->json([
                "status" => "Failed",
                "message" => "Can Not Send Link Payout. Link Expired!"
            ]);
        };

        if (!$payout->is_approved) {
            return response()->json([
                "status" => "Failed",
                "message" => "Can Not Send Link Payout. Need Approval!"
            ]);
        }

        \Log::debug('about to send it');
        $endPointUrl = str_replace('PAYOUT_ID', $payout->id, self::SEND_LINK);
        $data = $this->requestAPISendLink($endPointUrl);

        return response()->json([
            "status" => "OK",
            "message" => "Success Send Link!"
        ]);
    }

    public function approvePayout($id)
    {
        try {
            $payoutApprover = $this->payoutApprover();

            if(!$payoutApprover['approver']) {
                return response()->json([
                    "status" => "Failed",
                    "message" => "Not Authorized!"
                ]);
            }

            $payout = Payout::select(
                'id', 'expired_at'
                )->where('id', $id)->first();

            $expiry_date = $payout->expired_at;

            if ($expiry_date <= Carbon::now()) {
                \Log::debug('Payout Expired');
                return response()->json([
                    "status" => "Failed",
                    "message" => "Can Not Approve Payout. Link Expired!"
                ]);
            };

            payout::where('id', '=', $id)->update(
                [
                'is_approved' => true
                ]
            );

            return response()->json([
                "status" => "OK",
                "message" => "Approved!"
            ]);

        } catch (Exception $exception) {
            report($exception);
            DB::rollBack();
            if ($exception->getCode() == Response::HTTP_BAD_REQUEST) {
                return response()->json([
                    "status" => "Failed",
                    "message" => $exception->getMessage()
                ]);
            }

            return response()->json([
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function getBaseUrl() 
    {
        return $this->base_url;
    }

    private function requestAPI( $params, $endPointUrl ) 
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth_key,
        ];

        \Log::debug($params);
        try {
            $response = $this->httpClient->request('POST', $this->getBaseUrl() . $endPointUrl, [
                'json' => $params,
                'headers' => $headers
            ]);

            if ($response->getStatusCode() == Response::HTTP_OK) {
                $content = $response->getBody()->getContents();
                $content_json = json_decode($content);

                if(isset($content_json) && isset($content_json->error)){
                    throw new Exception($content_json->message);
                }

                if(isset($content_json) && isset($content_json->status)) {
                    if ($content_json->status != 'success') {
                        throw new Exception($content_json->data->content);
                    }
                }
                return $content_json;
            }
        } catch (RequestException $exception) {
            Log::error('Exception Get Message : ' . $exception->getResponse()->getBody());
            $body = json_decode($exception->getResponse()->getBody());

            // Client error: `POST intra-api.grosenia.co.id/v1/admin/payout` resulted in a `400 Bad Request` response: {"code":"400","message":"Nilai Payout maksimal 300000"}

            if ($exception->getCode() == Response::HTTP_INTERNAL_SERVER_ERROR) {
                Log::error($exception->getMessage());
                throw new Exception($body->message);
            }

            if ($exception->getCode() == Response::HTTP_BAD_REQUEST) {
                Log::error($exception->getMessage());
                throw new Exception($body->message);
            }

            if ($exception->getCode() == Response::HTTP_UNAUTHORIZED) {
                Log::error($exception->getMessage());
                throw new Exception($body->message);

            }
            if ($exception->getCode() == Response::HTTP_FORBIDDEN) {
                Log::error($exception->getMessage());
                throw new Exception($body->message);
            }
        }
    }

    private function requestAPISendLink( $endPointUrl ) 
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => $this->auth_key,
        ];

        try {
            $response = $this->httpClient->request('POST', $this->getBaseUrl() . $endPointUrl, [
                'headers' => $headers
            ]);

            if ($response->getStatusCode() == Response::HTTP_OK) {
                $content = $response->getBody()->getContents();
                $content_json = json_decode($content);
                
                if(isset($content_json) && isset($content_json->error)){
                    throw new Exception($content_json->message);
                }

                if(isset($content_json) && isset($content_json->status)) {
                    if ($content_json->status != 'success') {
                        throw new Exception($content_json->data->content);
                    }
                }
                return $content_json;
            }
        } catch (RequestException $exception) {
            Log::error('Exception Get Message : ' . $exception->getMessage());
            $body = json_decode($exception->getResponse()->getBody());

            if ($exception->getCode() == Response::HTTP_INTERNAL_SERVER_ERROR) {
                Log::error($exception->getMessage());
                throw new Exception($body->message);
            }

            if ($exception->getCode() == Response::HTTP_BAD_REQUEST) {
                Log::error($exception->getMessage());
                throw new Exception($body->message);
            }

            if ($exception->getCode() == Response::HTTP_UNAUTHORIZED) {
                Log::error($exception->getMessage());
                throw new Exception($body->message);
            }

            if ($exception->getCode() == Response::HTTP_FORBIDDEN) {
                Log::error($exception->getMessage());
                throw new Exception($body->message);
            }
        }
    }

    public function searchUser(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        \Log::debug($term);
        $posts = UserProfile::search($term)->limit(10)->get();

        $formatted_posts = [];

        foreach ($posts as $post) {
            $formatted_posts[] = ['id' => $post->msisdn, 'text' => $post->msisdn   . ', ' . $post->full_name ];
        }

        return \Response::json($formatted_posts);
    }



    private function payoutApprover() 
    {
        $user = auth()->user();
        $payoutApprover = PayoutApprover::where('admin_id', $user->id)->first();

        return $payoutApprover = [
            'user' => $user,
            'approver' => $payoutApprover
        ];
    }
}