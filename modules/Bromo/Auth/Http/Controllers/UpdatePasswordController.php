<?php

namespace Bromo\Auth\Http\Controllers;

use Illuminate\Routing\Controller;
//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Bromo\Auth\Models\Admin;
use Hash;
use Auth;
use Session;
use Redirect;

class UpdatePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->title = 'Change Password';
        $this->middleware('auth');
    }

    public function index()
    {
        $data['title'] = $this->title;
        return view('auth::update_password', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|confirmed|min:6|different:old_password'          
        ]);
        
        $user = Auth::user();
        $admin = Admin::findOrFail($user->id);
        $hashed_password= $admin->password;
        $old_password=$request->old_password;
        $new_password=$request->new_password;

        if (! Hash::check($old_password, $hashed_password) )
        {
            Session::flash('unauthorized', "Wrong Password");
            return Redirect::back();
        } 


        $admin->password = $new_password;
        
        $admin->save();
    
        return redirect()->route('dashboard');
    }
}