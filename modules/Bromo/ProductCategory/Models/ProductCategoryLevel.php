<?php

namespace Bromo\ProductCategory\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategoryLevel extends Model
{
    public $casts = [
        'updated_at' => 'timestamp'
    ];
    public $incrementing = false;
    protected $table = 'product_category_level';
    protected $dateFormat = 'Y-m-d H:i:s.uO';
}