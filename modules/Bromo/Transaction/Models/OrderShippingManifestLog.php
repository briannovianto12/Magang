<?php

namespace Bromo\Transaction\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class OrderShippingManifestLog extends Model
{
    use TimezoneAccessor, SnowFlakeTrait;

    const CREATED_AT = null;

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $fillable = [
        'id',
        'airwaybill',
        'carrier',
        'receiver',
        'status',
        'updated_at',
        'modified_by',
        'modifier_role',
        'version'
    ];

    protected $primaryKey = 'log_id';

    protected $table = 'order_shipping_manifest_log';
}