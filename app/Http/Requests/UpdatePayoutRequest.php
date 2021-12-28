<?php

namespace App\Http\Requests;

use App\Models\Payout;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePayoutRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('payout_edit');
    }

    public function rules()
    {
        return [
            'provider_id' => [
                'required',
                'integer',
            ],
            'amount' => [
                'required',
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
