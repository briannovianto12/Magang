<?php

namespace Bromo\Seller\Entities;

use Illuminate\Database\Eloquent\Model;
use Bromo\ShippingMapping\Entities\Logistic;

class CourierMapping extends Model
{
    protected $table = 'seller_courier_mapping';

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $fillable = [
        'courier_id',
        'seller_business_id',
        'remark',
        'created_at',
        'updated_at'
    ];

    public function shippingCourier()
    {
        return $this->belongsTo(Logistic::class, 'courier_id');
    }
}
