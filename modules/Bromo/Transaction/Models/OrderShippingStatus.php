<?php

namespace Bromo\Transaction\Models;

use Illuminate\Database\Eloquent\Model;

class OrderShippingStatus extends Model
{
    const CREATED = 1;
    const PACKAGING = 2;
    const PACKAGED = 3;
    const SHIPPED = 4;
    const PENDING = 5;
    const RETURNING = 6;
    const RETURNED = 7;
    const DELIVERED = 10;
    const CANCELED = 30;

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $table = 'order_shipping_status';
}