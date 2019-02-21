<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\Theme\Utils\FormatDates;
use Nbs\Theme\Utils\TimezoneAccessor;

class ProductVariant extends Model
{
    use FormatDates,
        TimezoneAccessor,
        SnowFlakeTrait;

    protected $table = 'product_variant';

    protected $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    protected $fillable = [
        'product_id',
        'sku',
        'name',
        'display_price',
        'stock_qty'
    ];

}