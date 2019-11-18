<?php

namespace Bromo\Refund\Entities;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class OrderRefund extends Model
{
    use FormatDates,
        SnowFlakeTrait,
        TimezoneAccessor;

    protected $table = 'order_refund';
    protected $fillable = [
        'order_id',
        'shop_id',
        'buyer_id',
        'notes',
        'refund_date',
        'order_refunded'
    ];
    protected $dateFormat = 'Y-m-d H:i:s.uO';

}