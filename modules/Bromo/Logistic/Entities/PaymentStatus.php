<?php


namespace Bromo\Logistic\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{

    /**
     * Set status model.
     */
    const PAYMENT_CREATED = 1;
    const PAYMENT_REQUESTED = 2;
    const PAYMENT_PENDING = 3;
    const PAYMENT_SUCCESS = 10;
    const PAYMENT_FAILED = 20;
    const PAYMENT_CANCELLED = 21;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_status';
}