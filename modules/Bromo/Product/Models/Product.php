<?php

namespace Bromo\Product\Models;

use Bromo\ProductCategory\Models\ProductCategory;
use Bromo\Seller\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class Product extends Model
{
    use FormatDates,
        SnowFlakeTrait,
        TimezoneAccessor;

    public $casts = [
        'id' => 'string',
        'image_files' => 'array',
        'dimensions' => 'array',
        'attributes' => 'array',
        'tags' => 'array',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    public $incrementing = false;
    protected $table = 'product';
    protected $dateFormat = 'Y-m-d H:i:sO';
    protected $fillable = [
        'shop_id',
        'name',
        'slug_name',
        'description',
        'image_files',
        'category_id',
        'category',
        'brand_id',
        'brand',
        'unit_type_id',
        'unit_type',
        'condition_type_id',
        'condition_type',
        'dimensions',
        'price_min',
        'price_max',
        'qty_min',
        'qty_max',
        'attributes',
        'tags',
        'status',
        'sku',
        'sku_part',
        'version'
    ];

    /*
    |--------------------------------------------------------------------------
    | Define some eloquent relationships
    |--------------------------------------------------------------------------
    */

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function productStatus()
    {
        return $this->belongsTo(ProductStatus::class, 'status');
    }

    public function productStatusNote()
    {
        return $this->hasOne(ProductStatusNotes::class, 'product_id', 'id');
    }

    /**
     * Get all of the variants product.
     *
     * @return HasMany
     */
    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }


    /*
    |--------------------------------------------------------------------------
    | Set accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Get the image files attribute.
     *
     * @param $value
     * @return mixed
     */
    public function getImageFilesUrlAttribute()
    {
        return files_attribute(config('product.path.product'), $this->image_files);
    }
}