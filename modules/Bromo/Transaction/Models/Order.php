<?php

namespace Bromo\Transaction\Models;

use Bromo\Buyer\Models\Business;
use Bromo\Buyer\Models\Buyer;
use Bromo\Buyer\Models\BuyerStatus;
use Bromo\Seller\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Traits\VersionModelTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class Order extends Model
{
    use FormatDates,
        SnowFlakeTrait,
        TimezoneAccessor,
        VersionModelTrait;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public $casts = [
        'id' => 'string',
        'buyer_snapshot' => 'array',
        'business_snapshot' => 'array',
        'shop_snapshot' => 'array',
        'orig_address_snapshot' => 'array',
        'dest_address_snapshot' => 'array',
        'shipping_service_snapshot' => 'array',
        'shipping_snapshot' => 'array',
        'payment_snapshot' => 'array',
        'payment_details' => 'array',
        'notes' => 'array',
        'payment_amount' => 'double',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_trx';

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s.uO';

    protected $appends = [
        'business_name',
        'seller_name',
        'payment_amount_formatted',
        'notes_admin'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_no',
        'buyer_id',
        'buyer_snapshot',
        'seller_id',
        'seller_snapshot',
        'shipping_courier_id',
        'shipping_service_code',
        'shipping_service_snapshot',
        'payment_method_id',
        'payment_snapshot',
        'orig_address_snapshot',
        'dest_address_snapshot',
        'payment_amount',
        'payment_details',
        'tax_no',
        'status',
        'shipping_status',
        'payment_status',
        'notes',
        'item_count',
        'reviewed',
        'expired_at',
        'modified_by',
        'modifier_role',
        'version'
    ];

    /*
    |--------------------------------------------------------------------------
    | Define some eloquent relationships
    |--------------------------------------------------------------------------
    */

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function seller()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function logs()
    {
        return $this->hasMany(OrderLog::class, 'order_trx_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_trx_id', 'id');
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'status');
    }

    public function paymentStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'payment_status');
    }

    public function shippingStatus()
    {
        return $this->belongsTo(ShippingStatus::class, 'shipping_status');
    }

    public function shippingCourier()
    {
        return $this->belongsTo(ShippingCourier::class);
    }

    public function shippingManifest()
    {
        return $this->hasMany(OrderShippingManifest::class, 'order_id');
    }

    public function itemShipment()
    {
        return $this->hasMany(OrderItemShipment::class, 'order_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Define some attributes
    |--------------------------------------------------------------------------
    */

    public function getPaymentAmountFormattedAttribute()
    {
        return number_format($this->payment_amount);
    }

    public function getPaymentMethodNameAttribute(): string
    {
        return $this->payment_snapshot['name'] ?? 'N/A';
    }

    public function getNotesAdminAttribute(): string
    {
        return $this->notes['admin'] ?? '';
    }

    // Buyer section
    public function getBuyerAvatarAttribute(): string
    {
        return file_attribute('buyer.path_avatar', $this->buyer_snapshot['avatar_file'] ?? null);
    }

    public function getBuyerNameAttribute(): string
    {
        return $this->buyer_snapshot['full_name'] ?? '-';
    }

    public function getBuyerPhoneNoAttribute(): string
    {
        return $this->buyer_snapshot['msisdn'] ?? '-';

    }

    public function getBuyerStatusAttribute(): string
    {
        return BuyerStatus::find($this->buyer_snapshot['status'])->name ?? '-';
    }

    // Business Section
    public function getBusinessLogoAttribute(): string
    {
        return file_attribute('buyer.path_business_logo', $this->business_snapshot['logo_file']);
    }

    public function getBusinessNameAttribute(): string
    {
        return presence($this->business_snapshot['name'], '-');
    }

    public function getBusinessTagAttribute(): string
    {
        return presence($this->business_snapshot['tag'], '-');
    }

    public function getBusinessTaxNoAttribute(): string
    {
        return presence($this->business_snapshot['tax_no'], '-');
    }

    // Seller Section
    public function getSellerLogoAttribute()
    {
        return file_attribute('shop.path_logo', $this->shop_snapshot['logo_file']);
    }

    public function getSellerNameAttribute(): string
    {
        return presence($this->shop_snapshot['name'], '-');
    }

    public function getSellerDescriptionAttribute()
    {
        return presence($this->shop_snapshot['description'], '-');
    }

    public function getSellerTaxNoAttribute()
    {
        return presence($this->shop_snapshot['tax_no'], '-');
    }

    public function getSellerProductCategoryAttribute()
    {
        return presence($this->shop_snapshot['product_category'], '-');
    }

    // Shipping section
    public function getOriginBuildingAttribute(): string
    {
        return $this->orig_address_snapshot['building_name'] ?? '-';
    }

    public function getOriginAddressAttribute(): string
    {
        $field = $this->orig_address_snapshot;
        if (is_array($field) == false) {
            return '';
        }
        $output = $field['address_line'] . '<br>';
        $output .= $field['subdistrict'] . ', ';
        $output .= $field['district'] . ', ';
        $output .= $field['city'] . ' ' . $field['city_type'] . '<br>';
        $output .= $field['province'] . ', ';
        $output .= $field['postal_code'];

        return $output;
    }

    public function getOriginNotesAttribute(): string
    {
        return $this->orig_address_snapshot['notes'] ?? '-';
    }

    public function getDestinationBuildingAttribute(): string
    {
        return $this->dest_address_snapshot['building_name'] ?? '-';
    }

    public function getDestinationAddressAttribute(): string
    {
        $field = $this->dest_address_snapshot;
        if (is_array($field) == false) {
            return '-';
        }
        $output = $field['address_line'] . '<br>';
        $output .= $field['subdistrict'] . ', ';
        $output .= $field['district'] . ', ';
        $output .= $field['city'] . ' ' . $field['city_type'] . '<br>';
        $output .= $field['province'] . ', ';
        $output .= $field['postal_code'];

        return $output;
    }

    public function getDestinationNotesAttribute(): string
    {
        return $this->dest_address_snapshot['notes'] ?? '-';
    }

    public function getShippingEstimatedAttribute(): string
    {
        return $this->shipping_service_snapshot['etd'] . " Hari" ?? '-';
    }

    public function getShippingCostAttribute(): string
    {
        return number_format($this->shipping_service_snapshot['cost']) ?? '-';
    }

}