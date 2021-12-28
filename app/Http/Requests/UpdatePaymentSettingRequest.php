<?php

namespace App\Http\Requests;

use App\Models\PaymentSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePaymentSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('payment_setting_edit');
    }

    public function rules()
    {
        return [
            'currency_id' => [
                'required',
                'integer',
            ],
            'tax_enabled' => [
                'required',
            ],
            'tax_percentage' => [
                'numeric',
                'required',
            ],
        ];
    }
}
