<?php

namespace Bromo\Order\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    const CREATED_AT = null;

    const PLACED = 1;
    const ACCEPTED = 2;
    const PAYMENT_REQUESTED = 3;
    const PAYMENT_PENDING = 4;
    const PAYMENT_OK = 5;
    const PACKAGED = 6;
    const SHIPPED = 7;
    const DELIVERED = 8;
    const SUCCESS = 10;

    const COMPLAINED = 20;
    const COMPLAIN_RESOLVED = 21;
    const REFUNDED = 22;

    const CANCELED = 30;
    const EXPIRED = 31;
    const REJECTED = 32;
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
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_status';


}