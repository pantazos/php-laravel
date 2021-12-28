<?php

namespace App\Observers;

use App\Http\Controllers\Traits\KeyGeneratingTrait;
use App\Models\PaymentMethod;

class PaymentMethodObserver
{
    use KeyGeneratingTrait;

    public function creating(PaymentMethod $paymentMethod)
    {
        $paymentMethod->key = $paymentMethod->key ?: $this->generateKey($paymentMethod);
    }
}
