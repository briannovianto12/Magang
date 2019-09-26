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
        // dd($user->getRoleNames());
        $data['user'] = $user;
        return view('dashboard::index', $data);
        
    }

    private function getSummary(){
        $thisMonth = DB::select("SELECT to_char(to_timestamp (DATE_PART('month', NOW())::text, 'MM'), 'Month')");
        $lastMonth = DB::select("SELECT to_char(to_timestamp ((DATE_PART('month', NOW())-1)::text, 'MM'), 'Month')");
        $totalRegisteredSeller = DB::select("SELECT public.f_get_total_seller()");
        $totalRegisteredUser = DB::select("SELECT public.f_get_total_user()");
        $totalRegisteredSellerWithProduct = DB::select("SELECT public.f_get_sellers_with_total_product()");
        $totalRegisteredSku = DB::table('product')->count();
        $totalPublishedSku = DB::table('product')->where('status', ProductStatus::PUBLISH)->count();
        $totalUnpublishedSku = DB::table('product')->where('status', '!=', ProductStatus::PUBLISH)->count();
        $totalPlacedOrderThisMonth = DB::table('order_trx')->where('status', '=', OrderStatus::PLACED)
                                        ->where(DB::raw("(DATE_PART('year', NOW()) - DATE_PART('year', created_at::date)) * 12 +
                                        (DATE_PART('month', NOW()) - DATE_PART('month', created_at::date))"), '=', 0)
                                        ->count();
        $totalPlacedOrderLastMonth = DB::table('order_trx')->where('status', '=', OrderStatus::PLACED)
                                        ->where(DB::raw("(DATE_PART('year', NOW()) - DATE_PART('year', created_at::date)) * 12 +
                                        (DATE_PART('month', NOW()) - DATE_PART('month', created_at::date))"), '=', 1)
                                        ->count();
        $totalOrderAwaitingSellerConfirmationThisMonth = DB::table('order_trx')->where('status', '=', OrderStatus::PAYMENT_OK)
                                        ->where(DB::raw("(DATE_PART('year', NOW()) - DATE_PART('year', created_at::date)) * 12 +
                                        (DATE_PART('month', NOW()) - DATE_PART('month', created_at::date))"), '=', 0)
                                        ->count();
        $totalOrderAwaitingSellerConfirmationLastMonth = DB::table('order_trx')->where('status', '=', OrderStatus::PAYMENT_OK)
                                        ->where(DB::raw("(DATE_PART('year', NOW()) - DATE_PART('year', created_at::date)) * 12 +
                                        (DATE_PART('month', NOW()) - DATE_PART('month', created_at::date))"), '=', 1)
                                        ->count();
        $totalOrderAwaitingShipmentThisMonth = DB::table('order_trx')->where('status', '=', OrderStatus::ACCEPTED)
                                        ->where(DB::raw("(DATE_PART('year', NOW()) - DATE_PART('year', created_at::date)) * 12 +
                                        (DATE_PART('month', NOW()) - DATE_PART('month', created_at::date))"), '=', 0)
                                        ->count();
        $totalOrderAwaitingShipmentLastMonth = DB::table('order_trx')->where('status', '=', OrderStatus::ACCEPTED)
                                        ->where(DB::raw("(DATE_PART('year', NOW()) - DATE_PART('year', created_at::date)) * 12 +
                                        (DATE_PART('month', NOW()) - DATE_PART('month', created_at::date))"), '=', 1)
                                        ->count();
        $totalOrderShippedThisMonth = DB::table('order_trx')->where('status', '=', OrderStatus::SHIPPED)
                                        ->where(DB::raw("(DATE_PART('year', NOW()) - DATE_PART('year', created_at::date)) * 12 +
                                        (DATE_PART('month', NOW()) - DATE_PART('month', created_at::date))"), '=', 0)
                                        ->count();
        $totalOrderShippedLastMonth = DB::table('order_trx')->where('status', '=', OrderStatus::SHIPPED)
                                        ->where(DB::raw("(DATE_PART('year', NOW()) - DATE_PART('year', created_at::date)) * 12 +
                                        (DATE_PART('month', NOW()) - DATE_PART('month', created_at::date))"), '=', 1)
                                        ->count();
        $totalOrderDeliveredThisMonth = DB::table('order_trx')->where('status', '=', OrderStatus::DELIVERED)
                                        ->where(DB::raw("(DATE_PART('year', NOW()) - DATE_PART('year', created_at::date)) * 12 +
                                        (DATE_PART('month', NOW()) - DATE_PART('month', created_at::date))"), '=', 0)
                                        ->count();
        $totalOrderDeliveredLastMonth = DB::table('order_trx')->where('status', '=', OrderStatus::DELIVERED)
                                        ->where(DB::raw("(DATE_PART('year', NOW()) - DATE_PART('year', created_at::date)) * 12 +
                                        (DATE_PART('month', NOW()) - DATE_PART('month', created_at::date))"), '=', 1)
                                        ->count();
        $totalOrderSucceededThisMonth = DB::table('order_trx')->where('status', '=', OrderStatus::SUCCESS)
                                        ->where(DB::raw("(DATE_PART('year', NOW()) - DATE_PART('year', created_at::date)) * 12 +
                                        (DATE_PART('month', NOW()) - DATE_PART('month', created_at::date))"), '=', 0)
                                        ->count();
        $totalOrderSucceededLastMonth = DB::table('order_trx')->where('status', '=', OrderStatus::SUCCESS)
                                        ->where(DB::raw("(DATE_PART('year', NOW()) - DATE_PART('year', created_at::date)) * 12 +
                                        (DATE_PART('month', NOW()) - DATE_PART('month', created_at::date))"), '=', 1)
                                        ->count();

        return [
            'this_month' => $thisMonth[0],
            'last_month' => $lastMonth[0],
            'total_registered_seller' => $totalRegisteredSeller[0]->f_get_total_seller,
            'total_registered_user' => $totalRegisteredUser[0]->f_get_total_user,
            'total_registered_seller_with_product' => $totalRegisteredSellerWithProduct[0]->f_get_sellers_with_total_product,
            'total_registered_sku' => $totalRegisteredSku,
            'total_published_sku' => $totalPublishedSku,
            'total_unpublished_sku' => $totalUnpublishedSku,
            'total_placed_order_this_month' => $totalPlacedOrderThisMonth,
            'total_placed_order_last_month' => $totalPlacedOrderLastMonth,
            'total_order_awaiting_seller_confirmation_this_month' => $totalOrderAwaitingSellerConfirmationThisMonth,
            'total_order_awaiting_seller_confirmation_last_month' => $totalOrderAwaitingSellerConfirmationLastMonth,
            'total_order_awaiting_shipment_this_month' => $totalOrderAwaitingShipmentThisMonth,
            'total_order_awaiting_shipment_last_month' => $totalOrderAwaitingShipmentLastMonth,
            'total_order_shipped_this_month' => $totalOrderShippedThisMonth,
            'total_order_shipped_last_month' => $totalOrderShippedLastMonth,
            'total_order_delivered_this_month' => $totalOrderDeliveredThisMonth,
            'total_order_delivered_last_month' => $totalOrderDeliveredLastMonth,
            'total_order_succeeded_this_month' => $totalOrderSucceededThisMonth,
            'total_order_succeeded_last_month' => $totalOrderSucceededLastMonth,
        ];


    }
}