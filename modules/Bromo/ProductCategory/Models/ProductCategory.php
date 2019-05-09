<?php

namespace Bromo\ProductCategory\Models;

use Bromo\Product\Models\ProductAttributeKey;
use Bromo\ProductBrand\Models\ProductBrand;
use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class ProductCategory extends Model
{
    use FormatDates,
        SnowFlakeTrait,
        TimezoneAccessor;

    public $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    public $incrementing = false;
    protected $table = 'product_category';
    protected $dateFormat = 'Y-m-d H:i:sO';
    protected $fillable = [
        'sku',
        'sku_part',
        'name',
        'parent_id',
        'level',
    ];

    public function children()
    {
        return $this->hasMany($this, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo($this, 'parent_id');
    }

    public function categoryLevel()
    {
        return $this->belongsTo(ProductCategoryLevel::class, 'level');
    }

    public function attributeKeys()
    {
        return $this->belongsToMany(
            ProductAttributeKey::class,
            'product_category_attribute_key',
            'category_id',
            'attribute_key'
        )->using(ProductCategoryAttributeKey::class)->withPivot([
            'sort'
        ])->withTimestamps();
    }

    public function brands()
    {
        return $this->belongsToMany(
            ProductBrand::class,
            'product_category_brand',
            'category_id',
            'brand_id'
        )->using(ProductCategoryBrand::class);
    }
}