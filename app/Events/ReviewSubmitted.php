<?php

namespace App\Events;

use App\Models\Review;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class ReviewSubmitted implements ShouldBroadcastNow
{
    use SerializesModels;

    public function __construct(public Review $review) {}

    public function broadcastOn(): array
    {
        return [new PrivateChannel('admin.notifications')];
    }

    public function broadcastAs(): string
    {
        return 'review.submitted';
    }

    public function broadcastWith(): array
    {
        return [
            'id'         => $this->review->id,
            'product'    => optional($this->review->product)->name,
            'rating'     => $this->review->rating,
            'user'       => optional($this->review->user)->name ?? 'Guest',
            'submitted'  => $this->review->created_at?->toIso8601String(),
            'review'    => $this->review->review,
        ];
    }
}
