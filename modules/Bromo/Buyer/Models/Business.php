<?php

namespace Bromo\Buyer\Models;

use Bromo\Buyer\Traits\JoinedAttribute;
use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class Business extends Model
{
    use FormatDates,
        JoinedAttribute,
        TimezoneAccessor;

    protected $appends = [
        'logo_url',
        'tax_image_url'
    ];

    public $casts = [
        'id' => 'string',
        'tag' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    public $incrementing = false;
    protected $table = 'business';
    protected $dateFormat = 'Y-m-d H:i:s.uO';
    protected $fillable = [
        'tag',
        'name',
        'description',
        'tax_no',
        'tax_no_image_file',
        'logo_file',
        'postal_code',
        'status'
    ];

    public function status()
    {
        return $this->belongsTo(BusinessStatus::class, 'status');
    }

    public function members()
    {
        return $this->belongsToMany(
            Buyer::class,
            'business_member',
            'business_id',
            'user_id'
        )
            ->using(BusinessMemberPivot::class)
            ->withPivot([
                'role',
                'status',
                'joined_at'
            ]);
    }

    public function bankAccounts()
    {
        return $this->hasMany(BusinessBankAccount::class, 'business_id');
    }

    public function getStatusNameAttribute(): string
    {
        return $this->status()->first()->name ?? '';
    }

    public function getLogoUrlAttribute()
    {
        return file_attribute('buyer.path_business_logo', $this->logo_file);
    }

    public function getTaxImageUrlAttribute()
    {
        return file_attribute('buyer.path_business_tax', $this->tax_no_image_file);
    }

    public function getOwner()
    {
        return $this
            ->members()
            ->wherePivot('role', BusinessMemberRole::OWNER)
            ->first();
    }
}