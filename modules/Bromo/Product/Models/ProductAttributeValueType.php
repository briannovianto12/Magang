<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class ProductAttributeValueType extends Model
{
    use FormatDates,
        TimezoneAccessor,
        SnowFlakeTrait;

    const CREATED_AT = null;

    const DESCRIPTIVE = 1;
    const OPTIONS = 2;

    protected $table = 'product_attribute_value_type';

    protected $fillable = [
        'name'
    ];

}