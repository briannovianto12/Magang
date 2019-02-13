<?php

namespace Bromo\Buyer\Models;

use Bromo\Theme\Utils\FormatDates;
use Bromo\Theme\Utils\TimezoneAccessor;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use FormatDates, TimezoneAccessor;

    protected $table = 'user_profile';

    public $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    public function sessions()
    {
        return $this->hasMany(BuyerSession::class, 'user_id');
    }

    public function status()
    {
        return $this->belongsTo(BuyerStatus::class, 'status');
    }

    public function business()
    {
        return $this->belongsToMany(
            Business::class,
            'business_member',
            'user_id',
            'business_id'
        )
            ->using(BusinessMemberPivot::class)
            ->first();
    }
}