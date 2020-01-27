<?php

namespace Bromo\Payout\Entities;

use Illuminate\Database\Eloquent\Model;

class PayoutReason extends Model
{
    protected $table = 'payout_reason';

    const PENGEMBALIAN_DANA = 1;
    const PENGGANTIAN_ONGKIR = 2;
    const PENGGANTIAN_SELISIH = 3;
}
