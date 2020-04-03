<?php

namespace Bromo\Tools\Entities;

use Illuminate\Database\Eloquent\Model;

class ShippingCourier extends Model
{
    protected $table = 'shipping_courier';

    protected $dateFormat = 'Y-m-d H:i:s.uO';
}
