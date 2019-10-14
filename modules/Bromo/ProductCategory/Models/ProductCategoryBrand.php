<?php

namespace Bromo\ProductCategory\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class ProductCategoryBrand extends Pivot
{
    use FormatDates,
        SnowFlakeTrait,
        TimezoneAccessor;

    const CREATED_AT = null;
    public $incrementing = false;
    protected $dateFormat = 'Y-m-d H:i:s.uO';
    protected $table = 'product_category_brand';
}