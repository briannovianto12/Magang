<?php

namespace Bromo\Transaction\DataTables;

use Bromo\Transaction\Models\OrderStatus;

class SuccessOrderDataTable extends OrderDatatable
{

    public function query()
    {
        $query = $this->model
            ->leftJoin('order_shipping_manifest','order_trx.id','=','order_shipping_manifest.order_id')
            ->select($this->getColumns())
            ->whereIn('order_trx.status', [
                OrderStatus::SUCCESS
            ])
            ->with('orderStatus:id,name');

        return $this->applyScopes($query);
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