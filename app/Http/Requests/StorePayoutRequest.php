<?php

namespace App\Http\Requests;

use App\Models\Payout;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePayoutRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('payout_create');
    }

    public function rules()
    {
        $available_amount = $this->input('available_amount');

        return [
            'provider_id' => [
                'required',
                'integer',
            ],
            'amount' => [
                'required',
                'numeric',
                'gt:0',
                'max:' . $available_amount
            ],
            'method' => [
                'required',
            ],
            'paid_at' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
        ];
    }
}
