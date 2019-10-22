<?php

namespace Bromo\Transaction\DataTables;

use Bromo\Transaction\Models\OrderStatus;

class PaidOrderDataTable extends ProcessOrderDataTable
{

    public function query()
    {
        $query = $this->model
            ->select($this->getColumns())
            ->where('status', OrderStatus::PAYMENT_OK)
            ->with('orderStatus:id,name');

        return $this->applyScopes($query);
    }
}
