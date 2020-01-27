<?php

namespace Bromo\Auth\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controller;
use DB;

use Bromo\Payout\Entities\PayoutApprover;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        $user = auth()->user();
        $adminRole = DB::table('admin_role')->select('name')->where('id', $user->role_id)->first();
        $user->syncRoles($adminRole->name);
        $data['user'] = $user;

        $payoutApprover = PayoutApprover::where('admin_id', $user->id)->first();
        if($payoutApprover) { 
            $user->givePermissionTo('view_payout_form');
            $user->givePermissionTo('view_payout');
        };

        return '/dashboard';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function form()
    {
        return view('auth::form');
    }
}
