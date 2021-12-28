<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can add a review.
     *
     * @param User $user
     * @param Booking $booking
     * @return bool
     */
    public function review(User $user, Booking $booking): bool
    {
        return $user->is_customer && $user->id === $booking->customer->id;
    }

    /**
     * Determine whether the user can accept the booking
     *
     * @param User $user
     * @return bool
     */
    public function accept(User $user): bool
    {
        return $user->is_provider;
    }

    /**
     * Determine whether the user is customer and can update the booking
     *
     * @param User $user
     * @param Booking $booking
     * @return bool
     */
    public function updateAsCustomer(User $user, Booking $booking): bool
    {
        return $user->is_customer && $user->id === $booking->customer->id;
    }

    /**
     * Determine whether the user is provider and can update the booking
     *
     * @param User $user
     * @param Booking $booking
     * @return bool
     */
    public function updateAsProvider(User $user, Booking $booking): bool
    {
        return $user->is_provider && $user->id === $booking->provider->id;
    }
}
