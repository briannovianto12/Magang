<?php

namespace Bromo\Seller\Models;

use Bromo\Buyer\Models\Business;
use Bromo\Buyer\Models\BusinessAddress;
use Bromo\Buyer\Models\BusinessBankAccount;
use Bromo\Buyer\Models\Buyer;
use Bromo\Seller\Entities\CommissionGroup;
use Bromo\ProductCategory\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\VersionModelTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class Shop extends Model
{
    use FormatDates,
        TimezoneAccessor,
        VersionModelTrait;

    public $casts = [
        'id' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    protected $table = 'shop';
    protected $appends = ['status_name', 'tax_image_url'];

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
        'status',
        'version',
        'is_temporary_closed',
        'temporary_closed_message'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function businessAddress()
    {
        return $this->belongsTo(BusinessAddress::class, 'address_id');
    }

    public function businessBankAccount()
    {
        return $this->belongsTo(BusinessBankAccount::class, 'bank_account_id');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function status()
    {
        return $this->belongsTo(ShopStatus::class, 'status');
    }

    public function survey()
    {
        return $this->hasOne(ShopSurvey::class, 'shop_id');
    }

    public function statusNotes()
    {
        return $this->hasMany(ShopStatusNote::class, 'shop_id');
    }

    public function index()
    {
        return $this->hasOne(ShopIndex::class, 'id');
    }

    public function getVersionName()
    {
        return 'version';
    }

    public function taxType()
    {
        return $this->belongsTo(TaxPayerType::class, 'taxpayer_type', 'id');
    }

    public function getStatusNameAttribute(): string
    {
        return $this->status()->first()->name ?? '';
    }

    public function getTaxImageUrlAttribute()
    {
        return file_attribute('shop.path_tax_image', $this->tax_card_image_file);
    }

    public function commissionType()
    {
        return $this->belongsTo(CommissionGroup::class, 'commission_group_id');
    }
}