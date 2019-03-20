<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Nbs\BaseResource\Traits\SnowFlakeTrait;
use Nbs\Theme\Utils\FormatDates;
use Nbs\Theme\Utils\TimezoneAccessor;

class ProductBuyingOption extends Model
{
    use FormatDates,
        TimezoneAccessor,
        SnowFlakeTrait;

    /**
     * Disable eloquent auto increment.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * Define a field for cast variable type.
     *
     * @var array
     */
    public $casts = [
        'id' => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_buying_option';
    /**
     * Configure format of date.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:sO';
    /**
     * Define a field for mass assignment.
     *
     * @var array
     */
    protected $fillable = [
        'variant_id',
        'product_id',
        'price_comp_base',
        'price_comp_margin',
        'price',
        'unit_type_id',
        'unit_type',
        'unit_qty',
        'qty_min',
        'qty_max',
        'sort',
        'version'
    ];

}