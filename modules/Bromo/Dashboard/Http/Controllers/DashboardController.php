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
use Bromo\Dashboard\Repositories\DashboardRepository;

class DashboardController extends Controller
{
    protected $dashboardRepository;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    

    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->middleware('auth');

        $this->dashboardRepository = $dashboardRepository;
    }

    public function index()
    {        
        $data['title'] = 'Dashbor';
        $data['breadcrumbs'] = [
           [ "name" => "Dashbor", "url" => route('dashboard') ]
        ];
        $data['summary'] = $this->getSummary();
        $data['order_statistics'] = $this->getOrderStatistics();
        
        $totals = $this->getOrderStatisticsTotal();
        if(isset($totals) && count($totals) > 0) {
            $data['order_statistics'][] = (object)[
                "status" => $totals[0]->status,
                "count_last_month" => $totals[0]->count_last_month,
                "this_month" => $totals[0]->this_month,
                "last_seven_days" => $totals[0]->last_seven_days,
                "amount_last_month" => $totals[0]->amount_last_month,
                "amount_this_month" => $totals[0]->amount_this_month,
                "amount_last_seven_days" => $totals[0]->amount_last_seven_days,
            ];
        }

        return view('dashboard::index', $data);
        
    }

    private function getSummary(){
        $totalRegisteredSeller = $this->dashboardRepository->getTotalRegisteredSeller();
        $totalRegisteredUser = $this->dashboardRepository->getTotalRegisteredUser();
        $totalRegisteredSellerWithProduct = $this->dashboardRepository->getTotalRegisteredSellerWithProduct();
        $totalRegisteredSku = $this->dashboardRepository->getTotalRegisteredSku();
        $totalPublishedSku = $this->dashboardRepository->getTotalPublishedSku();
        $totalUnpublishedSku = $this->dashboardRepository->getTotalUnpublishedSku();
        
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
        $orderStatistics = $this->dashboardRepository->getOrderStatistics();
        return $orderStatistics;
    }

    private function getOrderStatisticsTotal(){
        $orderStatisticsTotal = $this->dashboardRepository->getOrderStatisticsTotal();
        return $orderStatisticsTotal;
    }
}