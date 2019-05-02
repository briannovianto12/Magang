<?php

namespace Bromo\Order\DataTables;

use Bromo\Order\Models\OrderStatus;

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