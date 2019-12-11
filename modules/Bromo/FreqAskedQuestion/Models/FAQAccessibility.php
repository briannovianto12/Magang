<?php

namespace Bromo\FreqAskedQuestion\Models;

use Illuminate\Database\Eloquent\Model;

class FAQAccessibility extends Model
{
    const ALL = 1;
    const SELLER = 2;
    const BUYER = 3;
    
    protected $table = 'faq_accessibility';
    protected $fillable = [];
}
