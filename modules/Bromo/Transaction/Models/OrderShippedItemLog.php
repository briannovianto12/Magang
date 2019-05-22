<?php

namespace Bromo\Transaction\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class OrderShippedItemLog extends Model
{
    use TimezoneAccessor, SnowFlakeTrait;

    const CREATED_AT = null;

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $fillable = [
        'id',
        'qty_delivered',
        'qty_accepted',
        'qty_rejected',
        'updated_at',
        'modified_by',
        'modifier_role',
        'version'
    ];

    protected $table = 'order_shipped_item_log';

    protected $primaryKey = 'log_id';

}
