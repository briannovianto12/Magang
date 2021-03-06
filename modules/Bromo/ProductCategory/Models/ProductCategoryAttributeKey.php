<?php

namespace Bromo\ProductCategory\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class ProductCategoryAttributeKey extends Pivot
{
    use FormatDates,
        SnowFlakeTrait,
        TimezoneAccessor;

    public $casts = [
        'id' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    public $incrementing = false;
    protected $dateFormat = 'Y-m-d H:i:s.uO';
    protected $table = 'product_category_attribute_key';
    protected $fillable = [
        'category_id',
        'attribute_key',
        'sort'
    ];
}