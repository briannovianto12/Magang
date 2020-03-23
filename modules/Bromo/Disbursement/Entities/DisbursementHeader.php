<?php

namespace Bromo\Disbursement\Entities;

use Illuminate\Database\Eloquent\Model;

class DisbursementHeader extends Model
{
    protected $table = 'process_disbursement_header';

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $fillable = [
        'disbursement_header_no', 
        'amount', 
        'total_item', 
        'remark', 
        'created_by', 
    ];
}
