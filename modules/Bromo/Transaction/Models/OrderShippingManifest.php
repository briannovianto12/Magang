<?php

namespace Bromo\Transaction\Models;

use Bromo\Auth\Entities\Modifier;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\ModifierModelTrait;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Traits\VersionModelTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class OrderShippingManifest extends Model
{
    use FormatDates,
        SnowFlakeTrait,
        TimezoneAccessor,
        ModifierModelTrait;

    protected $casts = [
        'shipping_snapshot' => 'array',
        'carrier' => 'array',
        'receiver' => 'array'
    ];

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $fillable = [
        'order_id',
        'shipping_snapshot',
        'weight',
        'cost',
        'etd_min',
        'etd_max',
        'airwaybill',
        'carrier',
        'receiver',
        'status',
        'modified_by',
        'modifier_role',
        'version'
    ];

    protected $table = 'order_shipping_manifest';

    /*
    |--------------------------------------------------------------------------
    | Define some eloquent relationships
    |--------------------------------------------------------------------------
    */

    public function courierShippingLogs()
    {
        return $this->hasMany(CourierShippingLog::class, 'manifest_id');
    }

    public function shippingStatus()
    {
        return $this->belongsTo(OrderShippingStatus::class, 'status');
    }

    public function createShippingManifest(array $attributes = []): void
    {
        $this->refreshModifierField();
        $this->fill($attributes);
        $this->save();
        $this->refresh();
        $this->createLog();
    }

    private function createLog(): void
    {
        $this->logs()->create([
            'airwaybill' => $this->airwaybill,
            'carrier' => $this->carrier,
            'receiver' => $this->receiver,
            'status' => $this->status,
            'modified_by' => $this->modified_by,
            'modifier_role' => $this->modifier_role,
            'version' => $this->version
        ]);
    }

    //

    public function logs()
    {
        return $this->hasMany(OrderShippingManifestLog::class, 'id');
    }

    public function packaging()
    {
        $this->updateManifestByStatus(OrderShippingStatus::PACKAGING);
    }

    private function updateManifestByStatus(int $status): void
    {
        $this->update(['status' => $status]);
        $this->createLog();
    }

    // include create log

    /**
     * @param array $orderItemIds
     * @throws Exception
     */
    public function packagedItems(array $orderItemIds = []): void
    {
        // $orderItem contains ids of OrderItem model
        if (count($orderItemIds) == 0) {
            throw new Exception('At least must be packaged 1 Order Item');
        }

        $this->updateManifestByStatus(OrderShippingStatus::PACKAGED);
        $this->creatingOrderItemShipment($orderItemIds);
    }

    /**
     * @param array $orderItemIds
     * @throws Exception
     */
    private function creatingOrderItemShipment(array $orderItemIds): void
    {
        foreach ($orderItemIds as $id) {
            $orderItem = OrderItem::find($id);
            if (is_null($orderItem)) {
                throw new Exception('Invalid Order Item');
            }

            $this->prepareItemShipment($orderItem);
        }
    }

    private function prepareItemShipment(OrderItem $orderItem): void
    {
        $itemShipment = new OrderItemShipment();
        $itemShipment->fill([
            'order_id' => $this->order_id,
            'item_snapshot' => $orderItem->getAttributes(),
            'qty_total' => $orderItem->qty,
            'qty_unshipped' => $orderItem->qty, // same value from qty order item
            'qty_shipped' => 0,
            'qty_delivered' => 0,
            'qty_accepted' => 0,
            'qty_rejected' => 0,
            'modified_by' => auth()->user()->id,
            'modifier_role' => Modifier::SELLER
        ]);
        $itemShipment->save();
        $itemShipment->createLog();
    }

    /**
     * @param $itemShipmentIds
     * @param array $manifest
     * @throws Exception
     */
    public function shippedItem($itemShipmentIds, array $manifest = []): void
    {
        $this->update($manifest);
        $this->createLog();
        $this->shippedItemShipment($itemShipmentIds);
    }

    // Usable for Controller

    /**
     * @param array $itemShipmentIds
     * @throws Exception
     */
    public function shippedItemShipment(array $itemShipmentIds): void
    {
        foreach ($itemShipmentIds as $id) {
            $itemShipment = OrderItemShipment::find($id);
            if (is_null($itemShipment)) {
                throw new Exception('Invalid Item Shipment');
            }

            $this->prepareShippedItem($itemShipment);
        }
    }

    private function prepareShippedItem(OrderItemShipment $itemShipment): void
    {
        $shippedItem = $this->saveShippedItem($itemShipment);
        $shippedItem->createLog();

        $itemShipment->update([
            'qty_unshipped' => 0,
            'qty_shipped' => $itemShipment->qty_unshipped
        ]);
        $itemShipment->createLog();
    }

    private function saveShippedItem(OrderItemShipment $itemShipment)
    {
        return $this->orderShippedItems()->save(new OrderShippedItem([
            'order_item_id' => $itemShipment->id,
            'unit_type_id' => $itemShipment->item_snapshot['unit_type_id'],
            'unit_type' => $itemShipment->item_snapshot['unit_type'],
            'qty_shipped' => $itemShipment->qty_unshipped,
            'qty_delivered' => 0,
            'qty_accepted' => 0,
            'qty_rejected' => 0,
            'modified_by' => auth()->user()->id,
            'modifier_role' => Modifier::SELLER
        ]));
    }

    public function orderShippedItems()
    {
        return $this->hasMany(OrderShippedItem::class, 'manifest_id');
    }
}
