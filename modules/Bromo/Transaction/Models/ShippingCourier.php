<?php

namespace Bromo\Transaction\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCourier extends Model
{
    const CREATED_AT = null;
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public $casts = [
        'id' => 'string',
        'updated_at' => 'timestamp'
    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shipping_courier';

    protected $fillable = [
        'provider_key',
        'name'
    ];

}