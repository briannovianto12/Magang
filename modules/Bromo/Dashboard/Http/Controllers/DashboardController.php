<?php

namespace Bromo\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Bromo\Product\Models\ProductStatus;
use Bromo\Transaction\Models\OrderStatus;
use DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\HasRoles;
use Bromo\Auth\Models\Admin;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {        
        $data['title'] = 'Dashbor';
        $data['breadcrumbs'] = [
           [ "name" => "Dashbor", "url" => route('dashboard') ]
        ];
        $data['summary'] = $this->getSummary();
        $data['order_statistics'] = $this->getOrderStatistics();
        $user = auth()->user();
        
        if($user->role_id == 1){
            $user->syncRoles('Administrator');
        }else if($user->role_id == 2){
            $user->syncRoles('Merchandiser');
        }else if($user->role_id == 3){
            $user->syncRoles('Sales');
        }else if($user->role_id == 4){
            $user->syncRoles('Finance');
        }else if($user->role_id == 5){
            $user->syncRoles('Support');
        }
        $data['user'] = $user;
        return view('dashboard::index', $data);
        
    }

    private function getSummary(){
        $totalRegisteredSeller = DB::select("SELECT public.f_get_total_seller()");
        $totalRegisteredUser = DB::select("SELECT public.f_get_total_user()");
        $totalRegisteredSellerWithProduct = DB::select("SELECT public.f_get_sellers_with_total_product()");
        $totalRegisteredSku = DB::table('product')->count();
        $totalPublishedSku = DB::table('product')->where('status', ProductStatus::PUBLISH)->count();
        $totalUnpublishedSku = DB::table('product')->where('status', '!=', ProductStatus::PUBLISH)->count();
        
        return [
            'total_registered_seller' => $totalRegisteredSeller[0]->f_get_total_seller,
            'total_registered_user' => $totalRegisteredUser[0]->f_get_total_user,
            'total_registered_seller_with_product' => $totalRegisteredSellerWithProduct[0]->f_get_sellers_with_total_product,
            'total_registered_sku' => $totalRegisteredSku,
            'total_published_sku' => $totalPublishedSku,
            'total_unpublished_sku' => $totalUnpublishedSku
        ];
    }

    private function getGrossAmount($items){
        $grossAmount = 0;
        foreach($items as $item){
            $grossAmount += json_decode($item->item_amount);
        }

        return number_format($grossAmount, 0, 0, '.');;
    }

    private function getOrderStatistics(){
        $data = \DB::select("SELECT * FROM vw_order_statistics");
        return $data;
    }
}