<?php

namespace Bromo\Tools\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'location_city';

    /**
     * Configure format of date.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';
}
