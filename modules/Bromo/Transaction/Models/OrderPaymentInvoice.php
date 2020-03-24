<?php

namespace Bromo\Transaction\Models;

use Illuminate\Database\Eloquent\Model;
use Bromo\Transaction\Models\Order;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Traits\VersionModelTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class OrderPaymentInvoice extends Model
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
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    public $incrementing = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_payment_invoice';

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

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_no', 'order_no');
    }


}