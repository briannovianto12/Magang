<?php

namespace Bromo\Seller\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class ShopStatusNote extends Model
{
    use FormatDates,
        TimezoneAccessor,
        SnowFlakeTrait;

    const CREATED_AT = null;

    public $casts = [
        'shop_snapshot' => 'array',
        'updated_at' => 'timestamp'
    ];
    public $incrementing = false;
    protected $table = 'shop_status_note';
    protected $dateFormat = 'Y-m-d H:i:s.uO';
    protected $hidden = [
        'updated_at'
    ];

    protected $fillable = [
        'shop_snapshot',
        'status',
        'notes'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}