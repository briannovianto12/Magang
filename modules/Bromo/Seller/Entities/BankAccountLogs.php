<?php

namespace Bromo\Seller\Entities;

use Illuminate\Database\Eloquent\Model;

class BankAccountLogs extends Model
{
    protected $table = 'business_bank_account_log';

    protected $fillable = [
        'bank_account_id',	
        'business_id',	
        'account_no',	
        'account_owner_name',	
        'bank_id',	
        'bank_name',	
        'is_default',	
        'is_verified',	
        'modified_by',
        'modifier_role',
    ];

    const UPDATED_AT = 'created_at';
    protected $dateFormat = 'Y-m-d H:i:s.uO';
}