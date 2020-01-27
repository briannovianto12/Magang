<?php

namespace Bromo\Payout\Entities;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class UserProfile extends Model
{
    use Eloquence;
    protected $searchableColumns = [
        'full_name',
        'msisdn'
    ];

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $table = 'user_profile';
}
