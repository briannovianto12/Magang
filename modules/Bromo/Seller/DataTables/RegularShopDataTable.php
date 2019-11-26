<?php

namespace Bromo\Seller\DataTables;

use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;

class RegularShopDataTable extends DataTable
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
                    $action = "<button class='btn btn-sm btn-dark btn-add-to-popular-list' data-id='".$data->id."'><i class='fa fa-plus mr-1'></i>Add to Popular Shop</button>";
                }
                return $action;
            })
            ->rawColumns(['shop_name', 'action'])
            ->make(true);
    }

    public function query()
    {
        $query = $this->model->where('name', 'ilike', '%'.$this->keyword.'%')
                            ->leftJoin('popular_shop', 'shop.id', '=', 'popular_shop.shop_id')
                            ->whereNull('popular_shop.shop_id')
                            ->orderBy('name');

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
