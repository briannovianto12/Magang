<?php

namespace Bromo\Disbursement\Entities;

use Illuminate\Database\Eloquent\Model;

class SellerBalance extends Model
{
    
    protected $table = 'shop_current_balance';

    public $casts = [
        'updated_at' => 'string'
    ];

    protected $dateFormat = 'Y-m-d H:i:sO';

    
}
