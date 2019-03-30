<?php

namespace Bromo\Order\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Traits\VersionModelTrait;
use Nbs\Theme\Utils\FormatDates;
use Nbs\Theme\Utils\TimezoneAccessor;

class Order extends Model
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
        'buyer_snapshot' => 'array',
        'seller_snapshot' => 'array',
        'business_snapshot' => 'array',
        'shipping_snapshot' => 'array',
        'payment_snapshot' => 'array',
        'payment_details' => 'array',
        'notes' => 'array',
        'payment_amount' => 'double',
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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_trx';

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';

    protected $appends = [
        'business_name',
        'seller_name',
        'payment_amount_formatted',
        'notes_admin'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_no',
        'buyer_id',
        'buyer_snapshot',
        'seller_id',
        'seller_snapshot',
        'shipping_courier_id',
        'shipping_service_code',
        'shipping_snapshot',
        'payment_method_id',
        'payment_snapshot',
        'payment_amount',
        'payment_details',
        'tax_no',
        'status',
        'shipping_status',
        'payment_status',
        'notes',
        'item_count',
        'reviewed',
        'expired_at',
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
        return $this->hasMany(OrderLog::class, 'order_trx_id');
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'status');
    }

    public function shippingCourier()
    {
        return $this->belongsTo(ShippingCourier::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Define some attributes
    |--------------------------------------------------------------------------
    */

    public function getPaymentAmountFormattedAttribute()
    {
        return number_format($this->payment_amount);
    }

    public function getNotesAdminAttribute()
    {
        return $this->notes['admin'] ?? '';
    }

    public function getBusinessNameAttribute()
    {
        return $this->business_snapshot['name'] ?? '';
    }

    public function getSellerNameAttribute()
    {
        return $this->seller_snapshot['name'] ?? '';
    }


}