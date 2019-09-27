<?php

namespace Bromo\Report\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductPublished extends Model
{
    protected $table = 'vw_store_with_published_product_less_than_ten';
}
