<?php

namespace Bromo\Order\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItemStatus extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public $casts = [
        'id' => 'string',
        'product_snapshot' => 'array',
        'subtotal_details' => 'array',
        'notes' => 'array',
        'created_at' => 'timestamp',
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
    protected $table = 'order_item_status';


}