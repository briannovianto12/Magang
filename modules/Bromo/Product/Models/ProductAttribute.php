<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\FormatDates;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\BaseResource\Utils\TimezoneAccessor;

class ProductAttribute extends Model
{
    use FormatDates,
        TimezoneAccessor,
        SnowFlakeTrait;

    protected $table = 'product_attribute';

    protected $casts = [
        'id' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    protected $fillable = [
        'product_id',
        'key',
        'value_type',
        'value_option',
        'value',
    ];

    public function attributeKey()
    {
        return $this->belongsTo(ProductAttributeKey::class, 'key');
    }

    public function attributeValueType()
    {
        return $this->belongsTo(ProductAttributeValueType::class, 'value_type');
    }

    public function attributeValueOption()
    {
        return $this->belongsTo(ProductAttributeValueOption::class, 'value_option');
    }

}