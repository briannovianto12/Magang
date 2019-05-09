<?php

namespace Bromo\Transaction\DataTables;

use Bromo\Transaction\Models\OrderStatus;

class ProcessOrderDataTable extends OrderDatatable
{

    public function query()
    {
        $query = $this->model
            ->select($this->getColumns())
            ->whereIn('status', [
                OrderStatus::ACCEPTED,
                OrderStatus::PAYMENT_REQUESTED,
                OrderStatus::PAYMENT_PENDING,
                OrderStatus::PAYMENT_OK,
                OrderStatus::PACKAGING,
                OrderStatus::PACKAGED,
            ])
            ->with('orderStatus:id,name');

        return $this->applyScopes($query);
    }
}
