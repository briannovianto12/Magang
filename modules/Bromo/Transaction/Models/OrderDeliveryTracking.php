<?php

namespace Bromo\Transaction\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Traits\VersionModelTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class OrderDeliveryTracking extends Model
{
    use SnowFlakeTrait, VersionModelTrait, TimezoneAccessor;

    public $casts = [
        'created_at' => 'timestamp'
    ];

    protected $table = 'order_trx_delivery_tracking';
}