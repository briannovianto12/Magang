<?php

namespace Bromo\Transaction\DataTables;

use Bromo\Transaction\Models\OrderStatus;

class DeliveryOrderDataTable extends OrderDatatable
{
    public function query()
    {
        $defaultQuery = $this->model
            ->leftJoin('order_shipping_manifest','order_trx.id','=','order_shipping_manifest.order_id')
            ->select($this->getColumns())
            ->where('order_trx.status', OrderStatus::SHIPPED)
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

    protected function getColumns()
    {
        return [
            'order_trx.id',
            'order_trx.special_id',
            'order_trx.order_no',
            'order_trx.status',
            'order_trx.payment_amount',
            'order_trx.buyer_snapshot',
            'order_trx.shop_snapshot',
            'order_trx.payment_details',
            'order_trx.notes',
            'order_trx.is_picked_up',
            'order_trx.created_at',
            'order_trx.updated_at',
            'order_shipping_manifest.airwaybill'
        ];
    }
}