<?php

namespace Bromo\Order\DataTables;

use Bromo\Order\Models\OrderStatus;

class DeliveryOrderDataTable extends OrderDatatable
{

    public function query()
    {
        $query = $this->model
            ->whereIn('status', [OrderStatus::SHIPPED, OrderStatus::PARTIALLY_SHIPPED])
            ->with('orderStatus:id,name')
            ->latest('created_at');

        return $this->applyScopes($query);
    }
}