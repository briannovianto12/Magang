<?php

namespace Bromo\Seller\Models;

use Illuminate\Database\Eloquent\Model;

class ShopStatus extends Model
{
    const REG_SUBMITTED = 1;
    const SURVEY_SUBMITTED = 2;
    const VERIFIED = 3;
    const REJECTED = 4;
    const SUSPENDED = 5;

    public $incrementing = false;
    protected $table = 'shop_status';


}