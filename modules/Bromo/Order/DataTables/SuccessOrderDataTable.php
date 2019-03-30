<?php

namespace Bromo\Order\DataTables;

use Bromo\Order\Models\OrderStatus;

class SuccessOrderDataTable extends OrderDatatable
{

    public function query()
    {
        $query = $this->model
            ->where('status', OrderStatus::SUCCESS)
            ->with('orderStatus:id,name')
            ->latest('created_at');

        return $this->applyScopes($query);
    }
}