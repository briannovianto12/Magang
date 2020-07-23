<?php

namespace Bromo\Seller\Entities;

use Illuminate\Database\Eloquent\Model;

class ShopSuspended extends Model
{
    protected $table = 'shop_suspended';
    protected $primaryKey = 'shop_id';

    protected $dateFormat = 'Y-m-d H:i:s.uO';
}
