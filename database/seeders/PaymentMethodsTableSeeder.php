<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodsTableSeeder extends Seeder
{
    public function run()
    {
        PaymentMethod::create([
            'key' => 'cash',
            'name' => 'Cash',
            'enabled' => true
        ]);

        PaymentMethod::create([
            'key' => 'paypal',
            'name' => 'PayPal',
            'enabled' => true
        ]);
    }
}
