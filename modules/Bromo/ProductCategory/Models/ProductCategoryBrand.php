<?php

namespace Bromo\ProductCategory\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\Theme\Utils\FormatDates;
use Nbs\Theme\Utils\TimezoneAccessor;

class ProductCategoryBrand extends Pivot
{
    use FormatDates,
        SnowFlakeTrait,
        TimezoneAccessor;

    const CREATED_AT = null;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public $casts = [
        'id' => 'string',
        'updated_at' => 'timestamp'
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_category_brand';
}