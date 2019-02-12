<?php

namespace Bromo\Buyer\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $table = 'buyer';

    public function sessions()
    {
        return $this->hasMany(BuyerSession::class, 'user_id');
    }

    public function buyerStatus()
    {
        return $this->belongsTo(BuyerStatus::class, 'status');
    }
}