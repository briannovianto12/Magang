<?php

namespace Bromo\Transaction\Models;

use Illuminate\Database\Eloquent\Model;
// use Modules\Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Traits\TimezoneAccessor;
use Nbs\BaseResource\Traits\SnowFlakeTrait;

class OrderImage extends Model
{
    // use TimezoneAccessor;

    protected $fillable = [
        'id',
        'order_id',
        'filename',
        'created_at',
        'updated_at',
    ];

    protected $table = 'order_trx_images';
}