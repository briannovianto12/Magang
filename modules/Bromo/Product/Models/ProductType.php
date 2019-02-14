<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'product_type';

    protected $fillable = [
        'ext_id',
        'category_id',
        'name',
        'parent_id',
        'level',
        'sku_code'
    ];
}