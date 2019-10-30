<?php

namespace Bromo\Notifications\Events;

use Illuminate\Queue\SerializesModels;

class NewsNotificationByTopic
{
    use SerializesModels;

    public $dataPayload;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->dataPayload = $data;
    }
}
