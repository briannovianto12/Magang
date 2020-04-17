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
use Illuminate\Support\Facades\DB;
use Bromo\Buyer\Entities\FraudBlackListUser;
use Bromo\Buyer\Entities\UserProfile;
use Bromo\Buyer\Entities\UserStatus as Status;

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

    public function blacklistPhoneNumber(Request $request){
        $msisdn = $request->get('msisdn');

        $admin = \Auth::user()->id;
        $user = UserProfile::where('msisdn', $msisdn)->first();

        DB::beginTransaction();  
          
        try{
            if($user) {
                $fraud_blacklist_user = new FraudBlacklistUser;
                $fraud_blacklist_user->user_id = $user->id;
                $fraud_blacklist_user->fraud_status = 1;
                $fraud_blacklist_user->remark = 'blacklist by user id = '. \Auth::user()->id;
                $fraud_blacklist_user->save();
                
                $user->status = Status::BLOCKED;
                $user->save();
            } 

            else{
            // PREVENT FOR RE-REGISTRATION
            $phone_number_blacklist = new PhoneNumberBlacklist;
            $phone_number_blacklist->msisdn = $msisdn;
            $phone_number_blacklist->save();
            }

            DB::commit();
            \Log::debug('test');

            nbs_helper()->flashMessage('stored');

        }catch(\Exception $ex){            
            report($ex);
            // \Log::error($ex->getMessage());
            DB::rollBack();
            nbs_helper()->flashMessage('error');
        }
        return redirect()->back();     
    } 
}
