<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\Theme\Utils\FormatDates;
use Nbs\Theme\Utils\TimezoneAccessor;

class ProductAttribute extends Model
{
    use FormatDates,
        TimezoneAccessor,
        SnowFlakeTrait;

    protected $table = 'product_attribute';

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    protected $fillable = [
        'product_id',
        'key',
        'value_type',
        'value_option',
        'value',
    ];

}