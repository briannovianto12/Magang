<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\Theme\Utils\FormatDates;
use Nbs\Theme\Utils\TimezoneAccessor;

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