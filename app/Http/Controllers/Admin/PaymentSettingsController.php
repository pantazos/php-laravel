<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePaymentSettingRequest;
use App\Models\Currency;
use App\Models\PaymentSetting;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class PaymentSettingsController extends Controller
{
    public function edit(PaymentSetting $paymentSetting)
    {
        abort_if(Gate::denies('payment_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $currencies = Currency::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $paymentSetting->load('currency');

        return view('admin.paymentSettings.edit', compact('currencies', 'paymentSetting'));
    }

    public function update(UpdatePaymentSettingRequest $request, PaymentSetting $paymentSetting)
    {
        $paymentSetting->update($request->all());

        return redirect()->route('admin.payment-settings.edit', PaymentSetting::firstOrFail()->id);
    }
}
