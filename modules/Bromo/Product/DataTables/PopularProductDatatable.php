<?php

namespace Bromo\Product\DataTables;

use Bromo\Product\Models\ProductStatus;
use Yajra\DataTables\Services\DataTable;

class PopularProductDatatable extends DataTable
{
    public function ajax()
    {
        return datatables($this->query())
        ->addColumn('product_name', function ($data) {
            return $data->product_name;
        })
        ->addColumn('seller_name', function ($data) {
            return $data->shop_name;
        })
        ->addColumn('action', function ($data) {
            $action = null;
            // if(auth()->user()->hasPermissionTo('manage_popular_shops')){
                $action = "<button class='btn-remove-from-popular-list btn btn-sm btn-dark' data-id='".$data->product_id."'><i class='fa fa-times mr-1'></i>Remove</button>";
            // }
            return $action;
        })
        ->make(true);
    }

    public function query()
    {
        $query = $this->model->select('popular_product.product_id', 'popular_product.sort_by', 
                            'product.name as product_name', 'shop.name as shop_name')
                            ->join('product', 'product.id', '=', 'popular_product.product_id')
                            ->join('shop', 'product.shop_id', '=', 'shop.id');

        return $this->applyScopes($query);
    }

}