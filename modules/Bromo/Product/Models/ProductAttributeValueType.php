<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\Theme\Utils\FormatDates;
use Nbs\Theme\Utils\TimezoneAccessor;

class ProductAttributeValueType extends Model
{
    use FormatDates,
        TimezoneAccessor,
        SnowFlakeTrait;

    const CREATED_AT = null;

    protected $table = 'product_attribute_value_type';

    protected $fillable = [
        'name'
    ];

}