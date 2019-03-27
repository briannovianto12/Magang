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
                //TODO GET SELLER NAME FROM SNAPSHOT
                return '';
            })
            ->addColumn('buyer_name', function ($data) {
                //TODO GET BUYER NAME FROM SNAPSHOT
                return '';
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
