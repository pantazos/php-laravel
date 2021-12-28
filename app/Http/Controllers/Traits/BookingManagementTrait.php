<?php

namespace App\Http\Controllers\Traits;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

trait BookingManagementTrait
{
    /**
     * Mark booking as done, create a new payment object and save it this customer
     * @param $paymentMethodKey -> payment method used in this transaction (e.g. paypal, razorpay)
     */
    public function closeBooking(Request $request, Booking $booking, $paymentMethodKey)
    {
        // Update booking status to done and calculate the earnings
        $booking->markAsDone();

        // Create a new payment record
        $payment = new Payment(['amount' => $booking->total]);

        $user = $request->user();
        $payment->user()->associate($user);

        $paymentMethod = PaymentMethod::where('key', $paymentMethodKey)->firstOrFail();
        $payment->paymentMethod()->associate($paymentMethod);

        $payment->save();
    }
}
