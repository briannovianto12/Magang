<?php

namespace Bromo\Buyer\Entities;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'user_profile';
    protected $fillable = [
        'status'
    ];
    protected $dateFormat = 'Y-m-d H:i:s.uO';
}
