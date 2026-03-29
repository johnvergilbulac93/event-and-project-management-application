<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventCreatedMail extends Notification implements ShouldQueue
{
    use Queueable;

    public $event;
    public $type;
    public function __construct($event, $type)
    {
        $this->event = $event;
        $this->type = $type;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $subject = $this->type == 1
            ? 'Event Updated'
            : 'New Event Created';

        $line = $this->type == 1
            ? 'The event has been updated.'
            : 'A new event has been created.';
        return (new MailMessage)
            ->subject($subject)
            ->greeting('Hello, ' . $notifiable->first_name)
            ->line($line)
            ->line('Event: ' . $this->event->title)
            ->line('Date: ' . Carbon::parse($this->event->date)->format('F d, Y'))
            ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
