<?php

namespace Bromo\Product\Models;

use Bromo\ProductCategory\Models\ProductCategory;
use Bromo\Seller\Models\Shop;
use Bromo\Theme\Utils\FormatDates;
use Bromo\Theme\Utils\TimezoneAccessor;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use FormatDates, TimezoneAccessor;

    public $casts = [
        'image_files' => 'array',
        'category_tree' => 'array',
        'product_type_tree' => 'array',
        'dimension' => 'array',
        'display_attributes' => 'array',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    public $incrementing = false;
    protected $table = 'product';
    protected $dateFormat = 'Y-m-d H:i:s.uO';
    protected $fillable = [
        'ext_id',
        'shop_id',
        'name',
        'description',
        'image_files',
        'category_id',
        'category_tree',
        'product_type_id',
        'product_type_tree',
        'brand_id',
        'brand',
        'unit_type_id',
        'unit_type',
        'weight',
        'dimension',
        'display_price',
        'display_attributes',
        'status',
        'search_tags',
        'search_score'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function status()
    {
        return $this->belongsTo(ProductStatus::class, 'status');
    }
}