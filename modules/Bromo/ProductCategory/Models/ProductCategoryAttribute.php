<?php

namespace Bromo\ProductCategory\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\Theme\Utils\FormatDates;
use Nbs\Theme\Utils\TimezoneAccessor;

class ProductCategoryAttribute extends Model
{
    use FormatDates,
        SnowFlakeTrait,
        TimezoneAccessor;

    public $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    public $incrementing = false;
    protected $table = 'product_category_attribute';
    protected $fillable = [
        'category_id',
        'attribute_key',
        'sort'
    ];
}