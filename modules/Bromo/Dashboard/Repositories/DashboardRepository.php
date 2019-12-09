<?php

namespace Bromo\Dashboard\Repositories;
use Bromo\Product\Models\ProductStatus;
/**
 * Default implementation of Dashboard Repository
 */
interface DashboardRepository {

  /**
   * Get total registered seller (Verified One)
   */
  public function getTotalRegisteredSeller();

  /**
   * Get total registered user
   */
  public function getTotalRegisteredUser();

  /**
   * Get total registered seller with product
   */
  public function getTotalRegisteredSellerWithProduct();

  /**
   * Get total registered SKU
   */
  public function getTotalRegisteredSku();

  /**
   * Get total published SKU
   */
  public function getTotalPublishedSku();

  /**
   * Get total unpublished SKU
   */
  public function getTotalUnpublishedSku();

  /**
   * Get order statistics
   */
  public function getOrderStatistics();

  /**
   * Get order statistics total
   */
  public function getOrderStatisticsTotal();
}
