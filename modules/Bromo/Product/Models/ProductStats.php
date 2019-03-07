<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\Theme\Utils\FormatDates;
use Nbs\Theme\Utils\TimezoneAccessor;

class ProductStats extends Model
{
    use FormatDates,
        TimezoneAccessor,
        SnowFlakeTrait;

    const CREATED_AT = null;

    protected $table = 'product_stats';

    protected $casts = [
        'updated_at' => 'timestamp'
    ];

    protected $fillable = [
        'owner_id',
        'key',
        'value'
    ];
}