<?php

namespace Bromo\Seller\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use stdClass;

class ShopRegistrationLog extends Model
{
    use SnowFlakeTrait;

    const CREATED_AT = null;
    public $incrementing = false;
    protected $table = 'shop_registration_log';
    protected $fillable = [
        'shop_id',
        'shop_snapshot',
        'status',
        'notes',
        'modified_by',
        'modifier_role',
        'version'
    ];

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    public function setShopSnapshotAttribute($value)
    {
        $this->attributes['shop_snapshot'] = ($value) ? json_encode($value) : json_encode(new stdClass());
    }
}