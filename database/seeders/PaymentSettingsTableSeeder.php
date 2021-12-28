<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\PaymentSetting;
use Illuminate\Database\Seeder;

class PaymentSettingsTableSeeder extends Seeder
{
    public function run()
    {
        $paymentSettings = new PaymentSetting([
            'tax_enabled' => true,
            'tax_percentage' => 5
        ]);

        $usd = Currency::where('code', 'USD')->firstOrFail();
        $paymentSettings->currency()->associate($usd);
        $paymentSettings->save();
    }
}
