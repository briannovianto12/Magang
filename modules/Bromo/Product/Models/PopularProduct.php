<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;

class PopularProduct extends Model
{
    public $casts = [
        'product_id' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    
    protected $table = 'popular_product';

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $primaryKey = null;

    public $incrementing = false;

}