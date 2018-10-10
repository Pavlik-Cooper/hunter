<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ThreadWasUpdated extends Notification
{
    use Queueable;
    protected $reply;
    protected $thread;

    public function __construct($reply,$thread)
    {
        //
        $this->reply = $reply;
        $this->thread = $thread;
    }

    public function via($notifiable)
    {
        return ['database'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }


    public function toArray($notifiable)
    {
        return [
            'message'=> $this->reply->owner->name . ' replied to ' . $this->thread->title,
            'link'=> $this->reply->path(),
            'reply'=> json_encode($this->reply)
        ];
    }
}
