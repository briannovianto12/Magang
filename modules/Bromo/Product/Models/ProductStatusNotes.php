<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class ProductStatusNotes extends Model
{
    use FormatDates,
        SnowFlakeTrait,
        TimezoneAccessor;

    const CREATED_AT = null;

    public $casts = [
        'product_snapshot' => 'array',
        'updated_at' => 'timestamp'
    ];
    public $incrementing = false;

    protected $table = 'product_status_note';
    protected $dateFormat = 'Y-m-d H:i:sO';
    protected $fillable = [
        'product_id',
        'product_snapshot',
        'notes',
        'status'
    ];
}