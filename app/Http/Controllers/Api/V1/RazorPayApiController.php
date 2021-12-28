<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\PaymentClients\RazorPayClient;
use App\Http\Controllers\Traits\BookingManagementTrait;
use App\Http\Controllers\Traits\MoneyTrait;
use App\Http\Resources\Api\BookingResource;
use App\Models\Booking;
use App\Models\PaymentMethod;
use App\Models\PaymentSetting;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RazorPayApiController
{
    use BookingManagementTrait, MoneyTrait;

    /**
     * Create a RazorPay order for the sent booking_key
     */
    public function createOrder(Request $request): Response
    {
        $isRazorPayPaymentsEnabled = PaymentMethod::byKey('razorpay')->firstOrFail()->enabled;
        if (!$isRazorPayPaymentsEnabled) {
            return response(['message' => 'RazorPay payments is not enabled'], 400);
        }

        $request->validate([
            'booking_key' => 'required|string'
        ]);

        $booking = Booking::where('key', $request->input('booking_key'))->firstOrFail();
        $currencyCode = PaymentSetting::firstOrFail()->load('currency')->currency->code;

        $orderData = [
            'receipt' => $booking->key,
            'amount' => $this->moneyFormat($booking->total, $currencyCode),
            'currency' => $currencyCode
        ];

        $api = RazorPayClient::client();
        $order = $api->order->create($orderData);

        return response(['id' => $order->id]);
    }

    /**
     * Capture RazorPay order and create new payment
     */
    public function captureOrder(Request $request): Response
    {
        $request->validate([
            'booking_key' => 'required|string',
            'payment_id' => 'required|string'
        ]);

        $booking = Booking::where('key', $request->input('booking_key'))->firstOrFail();
        $currencyCode = PaymentSetting::firstOrFail()->load('currency')->currency->code;

        $api = RazorPayClient::client();
        try {
            $api->payment
                ->fetch($request->input('payment_id'))
                ->capture(array(
                    'amount' => $this->moneyFormat($booking->total, $currencyCode),
                    'currency' => $currencyCode
                ));

            $this->closeBooking($request, $booking, 'razorpay');
            return response(new BookingResource($booking));
        } catch (Exception $e) {
            return response(['message' => $e->getMessage()], 400);
        }
    }
}
