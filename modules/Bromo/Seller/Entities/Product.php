<?php

namespace Bromo\Seller\Entities;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = [
        'status'
    ];
    protected $dateFormat = 'Y-m-d H:i:s.uO';
}
