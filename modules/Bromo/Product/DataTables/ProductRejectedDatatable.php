<?php

namespace Bromo\Product\DataTables;

use Bromo\Product\Models\ProductStatus;
use Yajra\DataTables\Services\DataTable;

class ProductRejectedDatatable extends DataTable
{
    public function ajax()
    {
        return datatables($this->query())
            ->addIndexColumn()
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at_formatted;
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
            'product.name',
            'product.image_files',
            'product.condition_type',
            'product.category',
            'product.sku',

            'shop.name as shop_name',
            'product_status.name as status'
        ])->join('shop', 'shop.id', '=', 'product.shop_id')
            ->join('product_status', 'product_status.id', '=', 'product.status')
            ->where('product.status', ProductStatus::REJECT);

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