<?php

namespace Bromo\Transaction\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Traits\VersionModelTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class OrderItemShipment extends Model
{
    use SnowFlakeTrait, TimezoneAccessor, VersionModelTrait;

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $fillable = [
        'order_id',
        'item_snapshot',
        'qty_total',
        'qty_unshipped',
        'qty_shipped',
        'qty_delivered',
        'qty_accepted',
        'qty_rejected',
        'modified_by',
        'modifier_role',
        'version',
    ];

    protected $casts = [
        'item_snapshot' => 'array'
    ];

    protected $table = 'order_item_shipment';

    public function status()
    {
        return $this->belongsTo(OrderShippingStatus::class, 'status');
    }

    public function createLog()
    {
        $this->logs()->create([
            'qty_unshipped' => $this->qty_unshipped,
            'qty_shipped' => $this->qty_shipped,
            'qty_delivered' => $this->qty_delivered,
            'qty_accepted' => $this->qty_accepted,
            'qty_rejected' => $this->qty_rejected,
            'updated_at' => $this->updated_at,
            'modified_by' => $this->modified_by,
            'modifier_role' => $this->modifier_role,
            'version' => $this->version,
        ]);
    }

    public function logs()
    {
        return $this->hasMany(OrderItemShipmentLog::class, 'id');
    }
}