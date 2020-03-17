<?php

namespace Bromo\ShippingMapping\Entities;

use Illuminate\Database\Eloquent\Model;

class ShippingCourierCity extends Model
{
    protected $table = 'shipping_courier_city';
    protected $primaryKey = array('courier_id', 'city_id');
    protected $fillable = [
        'courier_id',
        'city_id',
        'created_at',
        'updated_at',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.uO';
    public $incrementing = false;

}


