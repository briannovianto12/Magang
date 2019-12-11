<?php

namespace Bromo\FreqAskedQuestion\Models;

use Illuminate\Database\Eloquent\Model;

class FAQCategory extends Model
{
    protected $table = 'faq_category';

    public function faq()
    {
        return $this->belongsTo(FreqAskedQuestion::class, 'faq_category');
    }
}
