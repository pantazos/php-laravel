<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBookingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('booking_edit');
    }

    public function rules()
    {
        return [
            'customer_id' => [
                'required',
                'integer',
            ],
            'service_id' => [
                'required',
                'integer',
            ],
            'extras.*' => [
                'integer',
            ],
            'extras' => [
                'array',
            ],
            'status_id' => [
                'required',
                'integer',
            ],
            'booking_at' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'notes' => [
                'string',
                'nullable',
            ],
            'latitude' => [
                'string',
                'required',
            ],
            'longitude' => [
                'string',
                'required',
            ],
            'address_name' => [
                'string',
                'required',
            ],
            'address_details' => [
                'string',
                'required',
            ]
        ];
    }
}
