<?php

namespace Bromo\Buyer\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use NBs\Theme\Utils\FormatDates;
use NBs\Theme\Utils\TimezoneAccessor;

class BusinessMemberPivot extends Pivot
{
    use FormatDates, TimezoneAccessor;

    public $casts = [
        'joined_at' => 'timestamp',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $appends = [
        'status_name',
        'role_name'
    ];

    protected $fillable = [
        'status',
        'role',
        'joined_at'
    ];

    public function getStatusNameAttribute(): string
    {
        return $this->status()->first()->name ?? '';
    }

    public function status()
    {
        return $this->belongsTo(BusinessMemberStatus::class, 'status');
    }

    public function getRoleNameAttribute(): string
    {
        return $this->role()->first()->name ?? '';
    }

    public function role()
    {
        return $this->belongsTo(BusinessMemberRole::class, 'role');
    }
}