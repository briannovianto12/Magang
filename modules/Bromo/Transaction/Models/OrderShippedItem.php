<?php

namespace Bromo\Transaction\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Traits\VersionModelTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class OrderShippedItem extends Model
{
    use SnowFlakeTrait, VersionModelTrait, TimezoneAccessor;

    const CREATED_AT = null;

    protected $fillable = [
        'id',
        'manifest_id',
        'order_item_id',
        'qty_shipped',
        'qty_delivered',
        'qty_accepted',
        'qty_rejected',
        'unit_type_id',
        'unit_type',
        'updated_at',
        'modified_by',
        'modifier_role',
        'version'
    ];

    protected $table = 'order_shipped_item';

    public function createLog()
    {
        $this->logs()->create([
            'qty_delivered' => $this->qty_delivered,
            'qty_accepted' => $this->qty_accepted,
            'qty_rejected' => $this->qty_rejected,
            'modified_by' => $this->modified_by,
            'modifier_role' => $this->modifier_role,
            'version' => $this->version
        ]);
    }

    public function logs()
    {
        return $this->hasMany(OrderShippedItemLog::class, 'id');
    }

}