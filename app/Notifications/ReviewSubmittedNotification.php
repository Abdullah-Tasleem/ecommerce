<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ReviewSubmittedNotification extends Notification
{
    use Queueable;

    public $review;

    /**
     * Create a new notification instance.
     */
    public function __construct($review)
    {
        $this->review = $review;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Store in database.
     */
    public function toDatabase($notifiable)
    {
        return [
            'message'   => "New {$this->review->rating}★ review on {$this->review->product->name} by {$this->review->user->name}: \"{$this->review->review}\"",
            'review_id' => $this->review->id,
            'rating'    => $this->review->rating,
            'product'   => $this->review->product->name,
            'user'      => $this->review->user->name,
            'review'    => $this->review->review,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'id'      => $this->review->id,
            'user'    => $this->review->user->name,
            'rating'  => $this->review->rating,
            'product' => $this->review->product->name,
            'review'  => $this->review->review,
        ]);
    }


    /**
     * Optional array format.
     */
    public function toArray($notifiable): array
    {
        return [
            'id'      => $this->review->id,
            'user'    => $this->review->user->name,
            'rating'  => $this->review->rating,
            'product' => $this->review->product->name,
            'excerpt' => $this->review->excerpt,
        ];
    }
}
