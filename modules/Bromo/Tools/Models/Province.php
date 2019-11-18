<?php

namespace Bromo\Tools\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'location_province';
    public $casts = [
        'id' => 'string',
        'country_id' => 'string',
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
