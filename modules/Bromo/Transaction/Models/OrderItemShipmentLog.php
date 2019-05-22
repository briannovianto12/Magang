<?php

namespace Bromo\Transaction\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class OrderItemShipmentLog extends Model
{
    use TimezoneAccessor, SnowFlakeTrait;

    const CREATED_AT = null;

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $fillable = [
        'id',
        'qty_unshipped',
        'qty_shipped',
        'qty_delivered',
        'qty_accepted',
        'qty_rejected',
        'updated_at',
        'modified_by',
        'modifier_role',
        'version'
    ];

    protected $primaryKey = 'log_id';

    protected $table = 'order_item_shipment_log';

}