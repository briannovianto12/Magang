<?php

namespace Bromo\ShippingMapping\Entities;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class LocationBuilding extends Model
{
    use Eloquence;
    protected $table = 'building';

    protected $searchableColumns = [
        'long_name',
        'short_name',
        'alias_name',
    ];

    protected $dateFormat = 'Y-m-d H:i:s.uO';
}
