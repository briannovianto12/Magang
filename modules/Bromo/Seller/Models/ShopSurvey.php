<?php

namespace Bromo\Seller\Models;

use Illuminate\Database\Eloquent\Model;

class ShopSurvey extends Model
{
    const UPDATED_AT = null;
    public $incrementing = false;
    protected $table = 'shop_survey';

    protected $casts = [
        'id' => 'string',
        'result' => 'array'
    ];
}