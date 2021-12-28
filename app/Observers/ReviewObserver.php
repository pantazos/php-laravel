<?php

namespace App\Observers;

use App\Http\Controllers\Traits\KeyGeneratingTrait;
use App\Models\Review;
use App\Models\Status;

class ReviewObserver
{
    use KeyGeneratingTrait;

    public function creating(Review $review)
    {
        $review->key = $review->key ?: $this->generateKey($review);
    }

    public function created(Review $review)
    {
        $reviewed = Status::byKey(Status::REVIEWED)->first();
        $review->booking->status()
            ->associate($reviewed)
            ->update();
    }
}
