<?php

namespace Bromo\Dashboard\Tests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Bromo\Dashboard\Repositories\DashboardRepositoryImpl;

class DashboardRepositoryTest extends TestCase
{
    /**
     * Test for get total registered seller
     *
     * @return void
     */
    public function testGetTotalRegisteredSeller()
    {
        $dashboardRepository = new DashboardRepositoryImpl();
        $total_registered_seller = $dashboardRepository->getTotalRegisteredSeller();

        $this->assertTrue(isset($total_registered_seller[0]));
        $this->assertTrue(isset($total_registered_seller[0]->f_get_total_seller));
        
        $this->assertEquals(8, $total_registered_seller[0]->f_get_total_seller);
    }

    /**
     * Test for get total registered user
     *
     * @return void
     */
    public function testGetTotalRegisteredUser()
    {
        $dashboardRepository = new DashboardRepositoryImpl();
        $total_registered_user = $dashboardRepository->getTotalRegisteredUser();

        $this->assertTrue(isset($total_registered_user[0]));
        $this->assertTrue(isset($total_registered_user[0]->f_get_total_user));
        
        $this->assertEquals(20, $total_registered_user[0]->f_get_total_user);
    }

    /**
     * Test for get total registered seller with product
     *
     * @return void
     */
    public function testGetTotalRegisteredSellerWithProduct()
    {
        $dashboardRepository = new DashboardRepositoryImpl();
        $total_registered_seller_with_product = $dashboardRepository->getTotalRegisteredSellerWithProduct();

        $this->assertTrue(isset($total_registered_seller_with_product[0]));
        $this->assertTrue(isset($total_registered_seller_with_product[0]->f_get_sellers_with_total_product));
        
        $this->assertEquals(6, $total_registered_seller_with_product[0]->f_get_sellers_with_total_product);
    }

    /**
     * Test for get total registered SKU
     *
     * @return void
     */
    public function testGetTotalRegisteredSku()
    {
        $dashboardRepository = new DashboardRepositoryImpl();
        $total_registered_sku = $dashboardRepository->getTotalRegisteredSku();

        $this->assertTrue(isset($total_registered_sku));
        
        $this->assertEquals(204, $total_registered_sku);
    }

    /**
     * Test for get total published sku
     *
     * @return void
     */
    public function testGetTotalPublishedSku()
    {
        $dashboardRepository = new DashboardRepositoryImpl();
        $total_published_sku = $dashboardRepository->getTotalPublishedSku();

        $this->assertTrue(isset($total_published_sku));
        
        $this->assertEquals(181, $total_published_sku);
    }

    /**
     * Test for get total unpublished SKU
     *
     * @return void
     */
    public function testGetTotalUnpublishedSku()
    {
        $dashboardRepository = new DashboardRepositoryImpl();
        $total_unpublished_sku = $dashboardRepository->getTotalUnpublishedSku();

        $this->assertTrue(isset($total_unpublished_sku));
        
        $this->assertEquals(23, $total_unpublished_sku);
    }

    /**
     * Test for get order statistics
     *
     * @return void
     */
    public function testGetOrderStatistics()
    {
        $dashboardRepository = new DashboardRepositoryImpl();
        $order_statistics = $dashboardRepository->getOrderStatistics();

        $this->assertTrue(isset($order_statistics));
        
        // TODO need to change with simulated data
        // $this->assertEquals(40, $order_statistics);
    }

    /**
     * Test for get order statistics total
     *
     * @return void
     */
    public function testGetOrderStatisticsTotal()
    {
        $dashboardRepository = new DashboardRepositoryImpl();
        $order_statistics_total = $dashboardRepository->getOrderStatisticsTotal();

        $this->assertTrue(isset($order_statistics_total));
        
        // TODO need to change with simulated data
        // $this->assertEquals(40, $order_statistics_total);
    }
}