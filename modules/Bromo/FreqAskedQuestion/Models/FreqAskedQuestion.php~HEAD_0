<?php

namespace Bromo\FreqAskedQuestion\Models;

use Illuminate\Database\Eloquent\Model;

class FreqAskedQuestion extends Model
{
    public $casts = [
        'id' => 'string',
        'tags' => 'array',
        'attachments' => 'array',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];
    protected $table = 'freq_asked_question';
    protected $dateFormat = 'Y-m-d H:i:s.uO';
    protected $fillable = [
        'title',
        'question',
        'answer',
        'faq_category',
        'accessible_by',
        'tags',
        'attachments',
        'is_visible',
        'sorty_by'
    ];

    public function accessibility()
    {
        return $this->hasOne(FAQAccessibility::class, 'id', 'accessible_by');
    }

    public function category()
    {
        return $this->hasOne(FAQCategory::class, 'id', 'faq_category');
    }
}
