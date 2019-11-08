<?php

namespace Bromo\Logistic\Entities;

use Illuminate\Database\Eloquent\Model;

class LogisticTrxImages extends Model
{
    protected $fillable = [
        'order_id',
        'filename',
    ];

    protected $table = 'order_trx_images';
}
