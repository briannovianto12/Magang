<?php

namespace Bromo\Transaction\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Traits\VersionModelTrait;
use Nbs\Theme\Utils\FormatDates;
use Nbs\Theme\Utils\TimezoneAccessor;

class OrderItem extends Model
{
    use FormatDates,
        SnowFlakeTrait,
        TimezoneAccessor,
        VersionModelTrait;

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
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_item';

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_trx_id',
        'product_id',
        'product_variant_id',
        'product_buying_opt_id',
        'product_snapshot',
        'qty',
        'unit_type_id',
        'unit_type',
        'status',
        'notes',
        'subtotal',
        'subtotal_details',
        'modified_by',
        'modifier_role',
        'version'
    ];

    /*
    |--------------------------------------------------------------------------
    | Define some eloquent relationships
    |--------------------------------------------------------------------------
    */

    public function logs()
    {
        //
    }

    public function orderItemStatus()
    {
        return $this->belongsTo(OrderItemStatus::class, 'status', 'id');
    }


    /*
    |--------------------------------------------------------------------------
    | Add accessors.
    |--------------------------------------------------------------------------
    */

    /**
     * Get payment details attribute.
     *
     * @param $value
     * @return mixed
     */
    public function getPaymentDetailsAttribute($value)
    {
        return json_decode($value);
    }


}