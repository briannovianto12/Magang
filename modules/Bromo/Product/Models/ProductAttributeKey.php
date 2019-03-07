<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Traits\VersionModelTrait;
use Nbs\Theme\Utils\FormatDates;
use Nbs\Theme\Utils\TimezoneAccessor;

class ProductAttributeKey extends Model
{
    use FormatDates,
        TimezoneAccessor,
        SnowFlakeTrait,
        VersionModelTrait;

    const CREATED_AT = null;

    protected $table = 'product_attribute_key';

    protected $dateFormat = 'Y-m-d H:i:sO';

    protected $casts = [
        'id' => 'string',
        'updated_at' => 'timestamp'
    ];

    protected $fillable = [
        'key',
        'value_type',
        'version'
    ];

    public function valueType()
    {
        return $this->belongsTo(ProductAttributeValueType::class, 'value_type');
    }

    public function options()
    {
        return $this->hasMany(ProductAttributeValueOption::class, 'key');
    }

    public function getVersionName()
    {
        return 'version';
    }

}