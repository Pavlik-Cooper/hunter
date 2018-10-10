<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifySubscribers
{

    public function handle(ThreadHasNewReply $event)
    {
        $thread = $event->reply->thread;

        $thread->subscriptions->where('user_id','!=',$event->reply->user_id)
            // ThreadSubscription->notify method here
            ->each->notify($event->reply);
    }
}
