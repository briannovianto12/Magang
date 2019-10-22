<?php

namespace Bromo\Transaction\DataTables;

use Bromo\Transaction\Models\OrderStatus;

class AcceptedOrderDataTable extends ProcessOrderDataTable
{

    public function query()
    {
        $query = $this->model
            ->select($this->getColumns())
            ->where('status', OrderStatus::ACCEPTED)
            ->with('orderStatus:id,name');

        return $this->applyScopes($query);
    }
}
