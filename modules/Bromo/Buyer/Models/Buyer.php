<?php

namespace Bromo\Buyer\Models;

use Bromo\ProductCategory\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class Buyer extends Model
{
    use FormatDates, TimezoneAccessor;

    protected $table = 'user_profile';

    public $casts = [
        'id' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    protected $appends = ['status_name'];

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public $incrementing = false;

    public function sessions()
    {
        return $this->hasMany(BuyerSession::class, 'user_id');
    }

    public function status()
    {
        return $this->belongsTo(BuyerStatus::class, 'status');
    }

    public function interests()
    {
        return $this->belongsToMany(ProductCategory::class, 'user_interest', 'user_id', 'category_id')
            ->using(UserInterest::class);
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

    public function getAvatarUrlAttribute()
    {
        return file_attribute('buyer.path_avatar', $this->avatar_file);
    }

    public function getNotificationTokens()
    {
        $tokens = $this->sessions()
            ->whereIn('device_type', [DeviceType::ANDROID, DeviceType::IOS])
            ->whereNotNull('notification_token')
            ->get();

        if (count($tokens) == 0) {
            return [];
        }

        return $tokens->map(function ($item) {
            return $item->notification_token;
        });
    }
}