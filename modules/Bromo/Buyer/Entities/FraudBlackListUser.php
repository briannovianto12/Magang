<?php

namespace Bromo\Buyer\Entities;

use Illuminate\Database\Eloquent\Model;

class FraudBlackListUser extends Model
{
    protected $table = 'fraud_blacklist_user';
    protected $fillable = [
        'user_id',
        'fraud_status',
        'remark'
    ];
}
