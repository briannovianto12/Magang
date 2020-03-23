<?php

namespace Bromo\Disbursement\Entities;

use Illuminate\Database\Eloquent\Model;

class DisbursementItem extends Model
{
    protected $table = 'process_disbursement_item';
    
    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $fillable = [
        'disbursement_header_id', 
        'amount', 
        'banck_code', 
        'bank_account_name', 
        'bank_account_number', 
        'description', 
        'email', 
        'email_cc', 
        'email_bcc', 
        'external_id', 
        'shop_name', 
        'created_at', 
        'updated_at',
    ];
}
