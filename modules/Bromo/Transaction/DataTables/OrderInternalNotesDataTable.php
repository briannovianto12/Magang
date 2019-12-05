<?php

namespace Bromo\Transaction\DataTables;

use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder;
use DB;

class OrderInternalNotesDataTable extends DataTable
{
    public function ajax()
    {
        return datatables($this->query())
            ->editColumn('created_at', function ($data) {
                return date_format($data->created_at, 'd-M-Y H:i:s');
            })
            ->make(true);
    }

    public function query()
    {
        $query = $this->model->select('order_trx_internal_notes.internal_notes', 'admin.name as admin_name', 'order_trx_internal_notes.created_at')
            ->where('order_id', $this->order_id)
            ->join('admin', 'admin.id', '=', 'order_trx_internal_notes.inputted_by')
            ->orderBy('order_trx_internal_notes.created_at', 'desc')->get();

        return $this->applyScopes($query);
    }
}
