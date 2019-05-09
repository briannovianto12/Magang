<?php

namespace Bromo\Transaction\DataTables;

use Bromo\Transaction\Models\OrderStatus;

class DeliveryOrderDataTable extends OrderDatatable
{

    public function query()
    {
        $query = $this->model
            ->select($this->getColumns())
            ->where('status', OrderStatus::SHIPPED)
            ->with('orderStatus:id,name');

        return $this->applyScopes($query);
    }
}