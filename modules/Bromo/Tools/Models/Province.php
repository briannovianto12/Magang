<?php

namespace Bromo\Tools\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'location_province';

    /**
     * Configure format of date.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';
}
