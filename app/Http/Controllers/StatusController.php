<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index(){
        try {
            $connection = \DB::select('select 1');
            return response('OK', 200);
        }
        catch (\Illuminate\Database\QueryException $queryException) {
            report($queryException);
            return abort(500);
        }
    }
}