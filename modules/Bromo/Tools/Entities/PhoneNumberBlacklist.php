<?php

namespace Bromo\Tools\Entities;

use Illuminate\Database\Eloquent\Model;

class PhoneNumberBlacklist extends Model
{
    protected $table = 'phone_number_blacklist';
    protected $fillable = [
        'msisdn'
    ];
    protected $primaryKey = 'msisdn';

    public function setUpdatedAtAttribute($value)
    {
        // to Disable updated_at
    }
    
}
