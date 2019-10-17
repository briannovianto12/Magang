<?php

namespace Bromo\Product\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductWeightLog extends Model
{
    protected $table = 'product_weight_log';

    protected $fillable = [
        'product_id',
        'old_weight',
        'updated_by',
        'modifier_role_id',
        'updated_at',
    ];

    const CREATED_AT = 'updated_at';
}
