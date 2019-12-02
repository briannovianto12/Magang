<?php

namespace Bromo\Transaction\DataTables;

use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder;

class OrderInternalNotesDataTable extends DataTable
{
    public function ajax()
    {
        return datatables($this->query())
            ->make(true);
    }

    public function query()
    {
        $query = $this->model->select('order_trx_internal_notes.internal_notes', 'admin.name as admin_name')
            ->where('order_id', $this->order_id)
            ->join('admin', 'admin.id', '=', 'order_trx_internal_notes.inputted_by')
            ->orderBy('order_trx_internal_notes.created_at', 'desc');

        return $this->applyScopes($query);
    }
}
