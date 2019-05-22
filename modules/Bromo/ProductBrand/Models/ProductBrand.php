<?php

namespace Bromo\ProductBrand\Models;

use Bromo\ProductCategory\Models\ProductCategory;
use Bromo\ProductCategory\Models\ProductCategoryBrand;
use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Traits\VersionModelTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class ProductBrand extends Model
{
    use FormatDates,
        TimezoneAccessor,
        SnowFlakeTrait,
        VersionModelTrait,
        HasSlug;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = null;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_brand';

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';

    public $incrementing = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'updated_at' => 'timestamp'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'slug_name',
        'sku_part',
        'version'
    ];

    public function getVersionName()
    {
        return 'version';
    }

    public function productCategories()
    {
        return $this->belongsToMany(
            ProductCategory::class,
            'product_category_brand',
            'brand_id',
            'category_id'
        )
            ->using(ProductCategoryBrand::class)
            ->withTimestamps();
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug_name')
            ->slugsShouldBeNoLongerThan(128);
    }
}