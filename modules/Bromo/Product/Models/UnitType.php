<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class UnitType extends Model
{
    use FormatDates, TimezoneAccessor;

    const CREATED_AT = null;
    public $casts = [
        'id' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    protected $fillable = [
        'name'
    ];
    protected $table = 'unit_type';
    protected $dateFormat = 'Y-m-d H:i:sO';

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function buyingOptions()
    {
        return $this->hasMany(ProductBuyingOption::class, 'unit_type_id');
    }
}