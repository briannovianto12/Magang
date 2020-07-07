<?php

namespace Bromo\Seller\Entities;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class ShippingCourier extends Model
{
    protected $table = 'shipping_courier';

    use Eloquence;
    protected $searchableColumns = [
        'provider_key',
        'name',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.uO';
}
