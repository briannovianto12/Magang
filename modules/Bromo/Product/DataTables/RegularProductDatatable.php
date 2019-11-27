<?php

namespace Bromo\Product\DataTables;

use Bromo\Product\Models\ProductStatus;
use Yajra\DataTables\Services\DataTable;

class RegularProductDatatable extends DataTable
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
                $action = "<button class='btn btn-sm btn-dark btn-add-to-popular-list' data-id='".$data->id."'><i class='fa fa-plus mr-1'></i>Add to Popular Product</button>";
            // }
            return $action;
        })
        ->make(true);
    }

    public function query()
    {                       
        $query = $this->model->select('product.id', 'product.name as product_name', 'shop.name as shop_name')
                            ->where('product.name', 'ilike', '%'.$this->keyword.'%')
                            ->leftJoin('popular_product', 'product.id', '=', 'popular_product.product_id')
                            ->join('shop', 'product.shop_id', '=', 'shop.id')
                            ->whereNull('popular_product.product_id')
                            ->orderBy('product.name');


        return $this->applyScopes($query);
    }

}