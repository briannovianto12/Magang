<?php

namespace Bromo\Notifications\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Bromo\Notifications\Events\NewsNotificationByTopic;
use Nbs\BaseResource\Services\FirebaseService;

class SendNewsNotificationByTopic implements ShouldQueue
{
    private $firebaseService;

    /**
     * Create the event listener.
     *
     * @param FirebaseService $firebaseService
     */
    public function __construct()//FirebaseService $firebaseService)
    {
        // $this->firebaseService = $firebaseService;
    }

    /**
     * Handle the event.
     *
     * @param NewsNotificationByTopic $event
     * @return void
     */
    public function handle(NewsNotificationByTopic $event)
    {
        $topic = $event->dataPayload['topic'];
        
        $dataPayload = [
            'title' => $event->dataPayload['title'],
            'body' => $event->dataPayload['body'],
        ];

        firebase()->sendToTopic($topic, $dataPayload);
    }
}
