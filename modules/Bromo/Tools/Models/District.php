<?php

namespace Bromo\Tools\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'location_district';
    public $casts = [
        'id' => 'string',
        'city_id' => 'string',
        'name' => 'string',
        'updated_at' => 'timestamps',
    ];

    /**
     * Configure format of date.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';
}
