<?php

namespace Bromo\Buyer\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{
    const CREATED_AT = null;
    const ANDROID = 1;
    const IOS = 2;
    const WEB = 3;
    public $incrementing = false;
    protected $table = 'device_type';
}