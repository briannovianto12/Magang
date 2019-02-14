<?php

namespace Bromo\ProductCategory\Models;

use Bromo\Theme\Utils\FormatDates;
use Bromo\Theme\Utils\TimezoneAccessor;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use FormatDates, TimezoneAccessor;

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