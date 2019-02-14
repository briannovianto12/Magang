<?php

namespace Bromo\Buyer\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\Theme\Utils\FormatDates;
use Nbs\Theme\Utils\TimezoneAccessor;

class Buyer extends Model
{
    use FormatDates, TimezoneAccessor;

    protected $table = 'user_profile';

    public $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    protected $appends = ['status_name'];

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function sessions()
    {
        return $this->hasMany(BuyerSession::class, 'user_id');
    }

    public function status()
    {
        return $this->belongsTo(BuyerStatus::class, 'status');
    }

    public function businesses()
    {
        return $this->belongsToMany(
            Business::class,
            'business_member',
            'user_id',
            'business_id'
        )
            ->using(BusinessMemberPivot::class)
            ->withPivot([
                'role',
                'status',
                'joined_at'
            ]);
    }

    public function getBusinessAttribute()
    {
        return $this->businesses()->first();
    }

    public function getStatusNameAttribute(): string
    {
        return $this->status()->first()->name ?? '';
    }
}