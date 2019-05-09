<?php

namespace Bromo\Transaction\DataTables;

use Bromo\Transaction\Models\OrderStatus;

class CancelOrderDataTable extends OrderDatatable
{

    public function query()
    {
        $query = $this->model
            ->select($this->getColumns())
            ->where('status', '>=', OrderStatus::CANCELED)
            ->with('orderStatus:id,name');

        return $this->applyScopes($query);
    }
}