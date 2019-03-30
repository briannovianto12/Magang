<?php

namespace Bromo\Order\DataTables;

use Yajra\DataTables\Services\DataTable;

abstract class OrderDatatable extends DataTable
{
    public function ajax()
    {
        return datatables($this->query())
            ->addIndexColumn()
            ->editColumn('created_at', function ($data) {
                return $data->created_at_formatted;
            })
            ->addColumn('seller_name', function ($data) {
                return $data->seller_name;
            })
            ->addColumn('buyer_name', function ($data) {
                return $data->business_name;
            })
            ->addColumn('payment_method', function ($data) {
                return $data->payment_snapshot['name'] ?? '';
            })
            ->addColumn('status_name', function ($data) {
                return $data->orderStatus->name ?? '';
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
        $query = $this->model
            ->with('orderStatus:id,name')
            ->latest('created_at');

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
