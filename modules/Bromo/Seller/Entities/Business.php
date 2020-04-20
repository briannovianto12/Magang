<?php

namespace Bromo\Seller\Entities;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $table = 'business';
    protected $fillable = [
        'description'
    ];
    protected $dateFormat = 'Y-m-d H:i:s.uO';
}
