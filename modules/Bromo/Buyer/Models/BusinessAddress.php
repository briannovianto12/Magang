<?php

namespace Bromo\Buyer\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class BusinessAddress extends Model
{
    use FormatDates, TimezoneAccessor;

    public $timestamps = false;
    public $casts = [
        'id' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    public $incrementing = false;
    protected $table = 'business_address';
    protected $dateFormat = 'Y-m-d H:i:s.uO';
    protected $fillable = [
        'business_id',
        'location_id',
        'location_type',
        'building_name',
        'address_line',
        'notes',
        'province',
        'city',
        'city_type',
        'district',
        'subdistrict',
        'postal_code',
        'is_default'
    ];

}