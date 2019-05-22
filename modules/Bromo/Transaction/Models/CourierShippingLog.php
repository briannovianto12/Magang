<?php

namespace Bromo\Transaction\Models;

use Illuminate\Database\Eloquent\Model;

class CourierShippingLog extends Model
{
    const CREATED_AT = null;

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $fillable = [
        'manifest_id',
        'status_code',
        'status_name',
        'status_description'
    ];

    protected $table = 'courier_shipping_log';

}
