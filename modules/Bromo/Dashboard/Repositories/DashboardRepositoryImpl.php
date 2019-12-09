<?php

namespace Bromo\Dashboard\Repositories;

use Bromo\Dashboard\Repositories\DashboardRepository;
use DB;
use Bromo\Product\Models\ProductStatus;

/**
 * Default implementation of Dashboard Repository
 */
class DashboardRepositoryImpl implements DashboardRepository {
     
  /**
   * Get total registered seller (Verified One)
   */
  public function getTotalRegisteredSeller() {
    return DB::select("SELECT public.f_get_total_seller()");
  }

  /**
   * Get total registered user
   */
  public function getTotalRegisteredUser() {
    return DB::select("SELECT public.f_get_total_user()");
  }
  
  /**
   * Get total registered seller with product
   */
  public function getTotalRegisteredSellerWithProduct() {
    return DB::select("SELECT public.f_get_sellers_with_total_product()");
  }

  /**
   * Get total registered SKU
   */
  public function getTotalRegisteredSku() {
    return DB::table('product')->count();
  }

  /**
   * Get total published SKU
   */
  public function getTotalPublishedSku() {
    return DB::table('product')->where('status', ProductStatus::PUBLISH)->count();
  }

  /**
   * Get total unpublished SKU
   */
  public function getTotalUnpublishedSku() {
    return DB::table('product')->where('status', '!=', ProductStatus::PUBLISH)->count();
  }

  /**
   * Get order statistics
   */
  public function getOrderStatistics() {
    $data = \DB::select("SELECT status,count_last_month,this_month,last_seven_days,amount_last_month,amount_this_month,amount_last_seven_days FROM vw_order_statistics");
    return $data;
  }

  /**
   * Get order statistics total
   */
  public function getOrderStatisticsTotal() {
    $data = \DB::select("SELECT 99 as status, count_last_month,amount_last_month,this_month,amount_this_month,last_seven_days,amount_last_seven_days FROM vw_order_statistics_total");
    return $data;
  }

}
