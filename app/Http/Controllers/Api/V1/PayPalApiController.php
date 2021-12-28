<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentClients\PayPalClient;
use App\Http\Controllers\Traits\BookingManagementTrait;
use App\Http\Resources\Api\BookingResource;
use App\Models\Booking;
use App\Models\PaymentMethod;
use App\Models\PaymentSetting;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use Symfony\Component\HttpFoundation\Response;

class PayPalApiController extends Controller
{
    use BookingManagementTrait;

    /**
     * Create a PayPal order for the sent booking_key
     */
    public function createOrder(Request $request): Response
    {
        $isPayPalPaymentsEnabled = PaymentMethod::byKey('paypal')->firstOrFail()->enabled;
        if (!$isPayPalPaymentsEnabled) {
            return response(['message' => 'PayPal payments is not enabled'], 400);
        }

        $request->validate([
            'booking_key' => 'required|string'
        ]);

        $booking = Booking::where('key', $request->input('booking_key'))->firstOrFail();
        $activeCurrency = PaymentSetting::firstOrFail()->load('currency')->currency;

        $payPalRequest = new OrdersCreateRequest();
        $payPalRequest->body = [
            "intent" => "CAPTURE",
            "application_context" => [
                "user_action" => "PAY_NOW"
            ],
            "purchase_units" => [
                [
                    "reference_id" => $booking->service->name . ' - ' . $booking->key,
                    "amount" => [
                        "value" => $booking->total,
                        "currency_code" => $activeCurrency->code
                    ]
                ]
            ]
        ];

        $client = PayPalClient::client();
        $response = $client->execute($payPalRequest);
        return response()->json($response->result);
    }

    /**
     * Capture PayPal order and create new payment
     */
    public function captureOrder(Request $request): Response
    {
        $request->validate([
            'booking_key' => 'required|string',
            'order_id' => 'required|string'
        ]);

        $booking = Booking::where('key', $request->input('booking_key'))->firstOrFail();
        $paypalRequest = new OrdersCaptureRequest($request->input('order_id'));
        $paypalRequest->prefer('return=representation');
        $client = PayPalClient::client();
        $response = $client->execute($paypalRequest);

        if ($response->statusCode == 200 || $response->statusCode == 201) {
            $this->closeBooking($request, $booking, 'paypal');
            return response(new BookingResource($booking));
        }

        return response()->json($response->result);
    }
}
