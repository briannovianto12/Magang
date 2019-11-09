<?php

namespace Bromo\Tools\Models;

use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    protected $table = 'location_subdistrict';

    /**
     * Configure format of date.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';
}
