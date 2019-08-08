<?php

namespace Bromo\Product\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStatus extends Model
{
    const SUBMIT = 1;
    const PUBLISH = 2;
    const REJECT = 3;
    const UNPUBLISH = 4;
    const SUSPEND = 5;

    const CREATED_AT = null;
    const UPDATED_AT = null;
    protected $table = 'product_status';
}
