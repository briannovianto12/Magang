<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStatus extends Model
{
    const SUBMIT = 1;
    const PUBLISH = 2;
    const UNPUBLISH = 3;
    const SUSPEND = 4;
    const REJECT = 5;

    const CREATED_AT = null;
    const UPDATED_AT = null;
    protected $table = 'product_status';
}