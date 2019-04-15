<?php

namespace Bromo\Order\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingStatus extends Model
{
    const CREATED_AT = null;

    const CREATED = 1;

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
    protected $table = 'shipping_status';

    protected $fillable = [
        'name'
    ];

}