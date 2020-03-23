<?php

namespace Bromo\Disbursement\Entities;

use Illuminate\Database\Eloquent\Model;

class DisbursementStatus extends Model
{
    const WAITING_TO_BE_PROCESSED =  1;
    const WAITING_FOR_APPROVAL =  2;
    const COMPLETED =  3;
    const CHECK =  4;
    const DELETED =  5;
    const FAILED =  6;

    const STR_WAITING_TO_BE_PROCESSED =  'Waiting To Be Processed';
    const STR_WAITING_FOR_APPROVAL =  'Waiting For Approval';
    const STR_COMPLETED =  'Completed';
    const STR_CHECK =  'Check';
    const STR_DELETED =  'Deleted';
    const STR_FAILED =  'Failed';


    protected $table = 'process_disbursement_status';
}
