<?php

namespace Bromo\Transaction\DataTables;

use Yajra\DataTables\Services\DataTable;

abstract class OrderDatatable extends DataTable
{
    public function ajax()
    {
        return datatables($this->query())
            ->addColumn('order_no', function ($data) {
                return '<a href="' . route('order.show', $data->id) .'">'.$data->order_no.'</a>';
            })
            ->rawColumns(['order_no'])
            ->editColumn('created_at', function ($data) {
                return $data->created_at_formatted;
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at_formatted;
            })
            ->addColumn('seller_name', function ($data) {
                return $data->seller_name;
            })
            ->addColumn('buyer_name', function ($data) {
                return $data->buyer_name;
            })
            ->addColumn('status_name', function ($data) {
                return $data->orderStatus->name ?? '';
            })
            ->make(true);
    }

    public function query()
    {
        $query = $this->model
            ->select($this->getColumns())
            ->with('orderStatus:id,name');

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

    protected function getColumns()
    {
        return [
            'id',
            'order_no',
            'status',
            'payment_amount',
            'buyer_snapshot',
            'shop_snapshot',
            'payment_snapshot',
            'notes',
            'created_at',
            'updated_at'
        ];
    }
}
