<?php

namespace Bromo\Seller\Entities;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = 'business_bank_account';

    protected $fillable = [
        'business_id',	
        'account_no',	
        'account_owner_name',	
        'bank_id',	
        'bank_name',	
        'is_default',	
        'is_verified',	
    ];

    protected $dateFormat = 'Y-m-d H:i:s.uO';
}
