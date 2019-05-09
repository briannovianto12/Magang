<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

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

    /*
    |--------------------------------------------------------------------------
    | Define some eloquent relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Get all of the buying options variant.
     *
     * @return HasMany
     */
    public function productBuyingOptions()
    {
        return $this->hasMany(ProductBuyingOption::class, 'variant_id', 'id');
    }

}