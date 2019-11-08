<?php

namespace Bromo\Logistic\Entities;

use Illuminate\Database\Eloquent\Model;

class TraditionalLogisticStatus extends Model
{
    /**
     * Set status model.
     */
    const WAITING_PICKUP = 1;
    const IN_PROCESS_PICKUP = 2;
    const PICKED_UP = 3;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logistic_organizer_status';
}
