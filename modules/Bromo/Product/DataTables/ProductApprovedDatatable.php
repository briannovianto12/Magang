<?php

namespace Bromo\Product\DataTables;

use Bromo\Product\Models\ProductStatus;
use Yajra\DataTables\Services\DataTable;

class ProductApprovedDatatable extends DataTable
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

                return view('theme::layouts.includes.actions', $action);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function query()
    {
        $query = $this->model->select([
            'product.id',
            'product.name',
            'product.image_files',
            'product.condition_type',
            'product.category',
            'product.sku',
            'product.created_at',
            'product.updated_at',

            'shop.name as shop_name',
            'product_status.name as status'
        ])->join('shop', 'shop.id', '=', 'product.shop_id')
            ->join('product_status', 'product_status.id', '=', 'product.status')
            ->whereIn('product.status', [ProductStatus::PUBLISH, ProductStatus::UNPUBLISH]);

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