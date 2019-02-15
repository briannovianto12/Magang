<?php

namespace Bromo\Buyer\Models;

use Bromo\Buyer\Traits\JoinedAttribute;
use Illuminate\Database\Eloquent\Model;
use Nbs\Theme\Utils\FormatDates;
use Nbs\Theme\Utils\TimezoneAccessor;

class Business extends Model
{
    use FormatDates,
        JoinedAttribute,
        TimezoneAccessor;

    public $casts = [
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
}