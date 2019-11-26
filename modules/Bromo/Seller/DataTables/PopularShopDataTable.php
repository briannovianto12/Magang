<?php

namespace Bromo\Seller\DataTables;

use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

class PopularShopDataTable extends DataTable
{
    public function ajax()
    {
        return datatables($this->query())
            ->addColumn('shop_name', function ($data) {
                return $data->name;
            })
            ->addColumn('action', function ($data) {
                $action = null;
                if(auth()->user()->hasPermissionTo('manage_popular_shops')){
                    $action = "<button class='btn-remove-from-popular-list btn btn-sm btn-dark' data-id='".$data->shop_id."'><i class='fa fa-times mr-1'></i>Remove</button>";
                }
                return $action;
            })
            ->rawColumns(['shop_name', 'action'])
            ->make(true);
    }

    public function query()
    {
        $query = $this->model->join('shop', 'shop.id', '=', 'popular_shop.shop_id');

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html()
    {
        
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
       
    }

}
