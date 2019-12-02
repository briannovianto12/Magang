<?php

namespace Bromo\Tools\Models;

use Illuminate\Database\Eloquent\Model;

class CourierBusinessMapping extends Model
{
    protected $table = 'courier_business_mapping';
    public $casts = [
        'id' => 'string',
        'seller_business_id' => 'string',
        'buyer_business_id' => 'string',
        'courier_id' => 'int',
        'created_at' => 'timestamps',
        'updated_at' => 'timestamps',
    ];

    protected $fillable = [
        'seller_business_id',
        'buyer_business_id',
        'courier_id',
    ];

    /**
     * Configure format of date.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';
}
