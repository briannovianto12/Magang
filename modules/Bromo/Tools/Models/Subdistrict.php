<?php

namespace Bromo\Tools\Models;

use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    protected $table = 'location_subdistrict';
    public $casts = [
        'id' => 'string',
        'district_id' => 'string',
        'name' => 'string',
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
