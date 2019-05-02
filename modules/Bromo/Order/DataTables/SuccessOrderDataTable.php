<?php

namespace Bromo\Order\DataTables;

use Bromo\Order\Models\OrderStatus;

class SuccessOrderDataTable extends OrderDatatable
{

    public function query()
    {
        $query = $this->model
            ->select($this->getColumns())
            ->whereIn('status', [OrderStatus::SUCCESS, OrderStatus::DELIVERED])
            ->with('orderStatus:id,name');

        return $this->applyScopes($query);
    }
}