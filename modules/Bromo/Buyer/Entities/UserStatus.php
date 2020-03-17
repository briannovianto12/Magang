<?php

namespace Bromo\Buyer\Entities;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    const UNVERIFIED = 1;
    const VERIFIED = 2;
    const BLOCKED = 3;
}
