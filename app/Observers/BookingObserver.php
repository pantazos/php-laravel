<?php

namespace App\Observers;

use App\Http\Controllers\Traits\KeyGeneratingTrait;
use App\Models\Booking;

class BookingObserver
{
    use KeyGeneratingTrait;

    public function creating(Booking $booking)
    {
        $booking->key = $booking->key ?: $this->generateKey($booking);
    }
}
