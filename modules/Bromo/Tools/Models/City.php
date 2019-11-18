<?php

namespace Bromo\Tools\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'location_city';
    public $casts = [
        'id' => 'string',
        'province_id' => 'string',
        'name' => 'string',
        'city_type_id' => 'int',
        'city_type_name' => 'string',
        'postal_code' => 'string',
        'updated_at' => 'timestamps',
    ];

    /**
     * Configure format of date.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';
}
