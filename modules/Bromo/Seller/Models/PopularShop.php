<?php

namespace Bromo\Seller\Models;

use Illuminate\Database\Eloquent\Model;

class PopularShop extends Model
{
    public $casts = [
        'shop_id' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    
    protected $table = 'popular_shop';

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $primaryKey = null;

    public $incrementing = false;
    
}