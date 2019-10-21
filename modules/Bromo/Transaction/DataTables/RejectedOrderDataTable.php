<?php

namespace Bromo\Transaction\DataTables;

use Bromo\Transaction\Models\OrderStatus;

class RejectedOrderDataTable extends OrderDatatable
{

    public function query()
    {
        $query = $this->model
            ->select($this->getColumns())
            ->whereIn('status', [
                OrderStatus::REJECTED
            ])
            ->with('orderStatus:id,name');

        $query->addSelect('reject_notes');
        return $this->applyScopes($query);
    }
}