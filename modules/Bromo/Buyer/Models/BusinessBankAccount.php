<?php

namespace Bromo\Buyer\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\Theme\Utils\FormatDates;
use Nbs\Theme\Utils\TimezoneAccessor;

class BusinessBankAccount extends Model
{
    use FormatDates, TimezoneAccessor;

    public $timestamps = false;
    public $casts = [
        'id' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    public $incrementing = false;
    protected $table = 'business_bank_account';
    protected $dateFormat = 'Y-m-d H:i:s.uO';
    protected $fillable = [
        'business_id',
        'account_no',
        'account_owner_name',
        'bank_id',
        'bank_name',
        'is_default'
    ];

}