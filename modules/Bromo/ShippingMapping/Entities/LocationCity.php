<?php

namespace Bromo\ShippingMapping\Entities;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class LocationCity extends Model
{
    protected $table = 'location_city';

    use Eloquence;
    protected $searchableColumns = [
        'name',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.uO';
}
