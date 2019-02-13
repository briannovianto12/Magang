<?php

namespace Bromo\Buyer\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessStatus extends Model
{
    const CREATED_AT = null;

    const UPDATED_AT = null;
    public $timestamps = false;
    protected $table = 'business_status';
}