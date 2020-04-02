<?php

namespace Bromo\Seller\Entities;

use Illuminate\Database\Eloquent\Model;

class BusinessAddress extends Model
{
    protected $table = 'business_address';

    protected $dateFormat = 'Y-m-d H:i:s.uO';
}
