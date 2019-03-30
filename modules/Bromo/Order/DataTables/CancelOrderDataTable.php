<?php

namespace Bromo\Order\DataTables;

use Bromo\Order\Models\OrderStatus;

class CancelOrderDataTable extends OrderDatatable
{

    public function query()
    {
        $query = $this->model
            ->where('status', '>=', OrderStatus::CANCELED)
            ->with('orderStatus:id,name')
            ->latest('created_at');

        return $this->applyScopes($query);
    }
}