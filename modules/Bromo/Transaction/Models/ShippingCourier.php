<?php

namespace Bromo\Transaction\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCourier extends Model
{

    CONST SHIPPING_PROVIDER_NINJAVAN = 1;
    CONST SHIPPING_PROVIDER_SHIPPER = 2;
    CONST SHIPPING_PROVIDER_KURIR_EKSPEDISI = 3;
    const CREATED_AT = null;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public $casts = [
        'id' => 'string',
        'updated_at' => 'timestamps'
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

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    public function getDates()
    {
        return [];
    }

}