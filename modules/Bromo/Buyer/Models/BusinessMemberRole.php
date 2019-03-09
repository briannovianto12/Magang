<?php

namespace Bromo\Buyer\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessMemberRole extends Model
{
    const CREATED_AT = null;
    const UPDATED_AT = null;
    const OWNER = 1;
    const MEMBER = 2;
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'business_member_role';

}