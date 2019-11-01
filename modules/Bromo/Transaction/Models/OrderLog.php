<?php

namespace Bromo\Transaction\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Traits\VersionModelTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class OrderLog extends Model
{
    use FormatDates,
        SnowFlakeTrait,
        TimezoneAccessor;

    const CREATED_AT = null;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public $casts = [
        'id' => 'string',
        'shipping_snapshot' => 'array',
        'payment_snapshot' => 'array',
        'payment_details' => 'array',
        'notes' => 'array',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    public $incrementing = false;

    protected $primaryKey = 'log_id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_trx_log';

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s.uO';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
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
        'updated_at',
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
}