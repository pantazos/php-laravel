<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentClients\StripeClient;
use App\Http\Controllers\Traits\BookingManagementTrait;
use App\Http\Controllers\Traits\MoneyTrait;
use App\Http\Resources\Api\BookingResource;
use App\Models\Booking;
use App\Models\PaymentMethod;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use Stripe\Exception\ApiErrorException;
use Symfony\Component\HttpFoundation\Response;

class StripeApiController extends Controller
{
    use BookingManagementTrait, MoneyTrait;

    public function createOrder(Request $request): Response
    {
        $isStripePaymentsEnabled = PaymentMethod::byKey('stripe')->firstOrFail()->enabled;
        if (!$isStripePaymentsEnabled) {
            return response(['message' => 'Stripe payments is not enabled'], 400);
        }

        $request->validate([
            'booking_key' => 'required|string'
        ]);

        $booking = Booking::where('key', $request->input('booking_key'))->firstOrFail();
        $currencyCode = PaymentSetting::firstOrFail()->load('currency')->currency->code;

        $stripe = StripeClient::client();

        try {
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $this->moneyFormat($booking->total, $currencyCode),
                'currency' => strtolower($currencyCode),
                'capture_method' => 'manual',
            ]);
            return response([
                'payment_id' => $paymentIntent->id,
                'client_secret' => $paymentIntent->client_secret
            ]);
        } catch (ApiErrorException $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }

    public function captureOrder(Request $request): Response
    {
        $request->validate([
            'booking_key' => 'required|string',
            'payment_id' => 'required|string'
        ]);

        $booking = Booking::where('key', $request->input('booking_key'))->firstOrFail();

        $stripe = StripeClient::client();

        try {
            $stripe->paymentIntents->capture($request->input('payment_id'));
            $this->closeBooking($request, $booking, 'stripe');
            return response(new BookingResource($booking));
        } catch (ApiErrorException $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }
}
