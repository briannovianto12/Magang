<?php

namespace Bromo\Tools\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'location_district';

    /**
     * Configure format of date.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';
}
