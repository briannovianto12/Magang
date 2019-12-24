<?php

namespace Bromo\Notifications\Entities;

use Illuminate\Database\Eloquent\Model;

class NewsNotification extends Model
{
    protected $table = 'news_notification';
    protected $fillable = [
        'topic',
        'title',
        'body'
    ];
}
