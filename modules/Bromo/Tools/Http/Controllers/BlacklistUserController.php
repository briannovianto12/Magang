<?php

namespace Bromo\Tools\Http\Controllers;

use Bromo\Tools\Models\City;
use Bromo\Tools\Models\District;
use Bromo\Tools\Models\Province;
use Bromo\Tools\Models\Subdistrict;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Bromo\Tools\Entities\PhoneNumberBlacklist;

class BlacklistUserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('tools::blacklist-phone-number');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('tools::create');
    }

    public function blacklistPhoneNumber(Request $request){
        $msisdn = $request->get('msisdn');
        // \Log::debug($msisdn);        
        try{
            $phone_number_blacklist = new PhoneNumberBlacklist;
            // \Log::debug('inside try');
            $phone_number_blacklist->msisdn = $msisdn;
            // \Log::debug($phone_number_blacklist->msisdn);
            $phone_number_blacklist->save();

            nbs_helper()->flashSuccess('Success Blacklisted Phone Number');
        }catch(\Exception $ex){ 
            // \Log::error($ex->getMessage());
            nbs_helper()->flashError($ex->getMessage());
        }
        return redirect()->back();     
    } 
}
