<?php

namespace Bromo\Transaction\DataTables;

use Bromo\Transaction\Models\OrderStatus;

class DeliveryOrderDataTable extends OrderDatatable
{

    public function query()
    {
        $defaultQuery = $this->model
            ->select($this->getColumns())
            ->where('status', OrderStatus::SHIPPED)
            ->with('orderStatus:id,name');

        $finalQuery = $defaultQuery;
        if($this->is_shipped === true){
            $finalQuery = $defaultQuery->where('is_picked_up', true);
        }
        else if($this->is_shipped === false){
            $finalQuery = $defaultQuery->where('is_picked_up', false);
        }

        return $this->applyScopes($finalQuery);
    }
}