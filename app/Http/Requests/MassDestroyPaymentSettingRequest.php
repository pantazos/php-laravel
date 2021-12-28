<?php

namespace App\Http\Requests;

use App\Models\PaymentSetting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPaymentSettingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('payment_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:payment_settings,id',
        ];
    }
}
