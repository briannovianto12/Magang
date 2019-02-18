<?php

namespace Bromo\ProductCategory\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\Theme\Utils\FormatDates;
use Nbs\Theme\Utils\TimezoneAccessor;

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
    protected $dateFormat = 'Y-m-d H:i:s.uO';
    protected $fillable = [
        'ext_id',
        'name',
        'parent_id',
        'level',
        'sku_code',
    ];

    public function children()
    {
        return $this->hasMany($this, 'parent_id');
    }
}