<?php

namespace Bromo\Seller\Models;

use Bromo\Buyer\Models\Business;
use Bromo\Theme\Utils\FormatDates;
use Bromo\Theme\Utils\TimezoneAccessor;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use FormatDates, TimezoneAccessor;

    public $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    protected $table = 'shop';
    protected $appends = ['status_name'];

    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'business_id',
        'name',
        'address_id',
        'bank_account_id',
        'tax_no',
        'tax_card_image_file',
        'product_category_id',
        'product_category',
        'status'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function getStatusNameAttribute(): string
    {
        return $this->status()->first()->name ?? '';
    }

    public function status()
    {
        return $this->belongsTo(ShopStatus::class, 'status');
    }
}