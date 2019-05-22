<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Traits\VersionModelTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class ProductAttributeValueOption extends Model
{
    use FormatDates,
        TimezoneAccessor,
        SnowFlakeTrait,
        VersionModelTrait;

    const CREATED_AT = null;

    protected $table = 'product_attribute_value_option';

    protected $dateFormat = 'Y-m-d H:i:sO';

    protected $casts = [
        'id' => 'string'
    ];

    protected $fillable = [
        'key',
        'value',
        'sku_part',
        'version'
    ];

    public function getVersionName()
    {
        return 'version';
    }

}