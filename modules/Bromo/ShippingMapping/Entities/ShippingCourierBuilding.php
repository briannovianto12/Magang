<?php

namespace Bromo\ShippingMapping\Entities;

use Illuminate\Database\Eloquent\Model;

class ShippingCourierBuilding extends Model
{
    protected $table = 'shipping_courier_building';
    protected $primaryKey = array('courier_id', 'building_id');
    protected $fillable = [
        'courier_id',
        'building_id',
        'created_at',
        'updated_at',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.uO';
    public $incrementing = false;

}


