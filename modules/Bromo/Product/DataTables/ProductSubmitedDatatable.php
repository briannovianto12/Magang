<?php

namespace Bromo\Product\DataTables;

use Bromo\Product\Models\ProductStatus;
use Yajra\DataTables\Services\DataTable;

class ProductSubmitedDatatable extends DataTable
{
    public function ajax()
    {
        return datatables($this->query())
            ->addIndexColumn()
            ->editColumn('created_at', function ($data) {
                return $data->created_at_formatted;
            })
            ->addColumn('action', function ($data) {
                $action = [
                    'show_url' => route("{$this->module}.show", $data->id),
                    'id' => $data->id
                ];

                return view('layouts.includes.actions', $action);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function query()
    {
        $query = $this->model->select([
            'product.id',
            'product.ext_id',
            'product.name',
            'product.unit_type',
            'product.display_price',
            'product.product_type_id',
            'product.created_at',

            'shop.name as shop_name',
            'product_status.name as status'
        ])->join('shop', 'shop.id', '=', 'product.shop_id')
            ->join('product_status', 'product_status.id', '=', 'product.status')
            ->where('product.status', ProductStatus::SUBMIT);

        return $this->applyScopes($query);
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return $this->module . "_" . time();
    }
}
