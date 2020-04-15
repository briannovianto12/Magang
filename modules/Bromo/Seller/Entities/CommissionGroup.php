<?php

namespace Bromo\Seller\Entities;

use Illuminate\Database\Eloquent\Model;

class CommissionGroup extends Model
{
    const STANDARD = 1;
    const PREMIUM = 2;

    protected $table = 'commission_group';
    protected $dateFormat = 'Y-m-d H:i:s.uO';
}
