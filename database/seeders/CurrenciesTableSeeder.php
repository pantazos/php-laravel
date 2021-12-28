<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    public function run()
    {
        Currency::create([
            'name' => 'US Dollar',
            'code' => 'USD',
            'symbol' => '$'
        ]);

        Currency::create([
            'name' => 'Euro',
            'code' => 'EUR',
            'symbol' => '€'
        ]);

        Currency::create([
            'name' => 'Indian Rupee',
            'code' => 'INR',
            'symbol' => 'টকা'
        ]);

        Currency::create([
            'name' => 'Saudi Riyal',
            'code' => 'SAR',
            'symbol' => 'SAR'
        ]);

        Currency::create([
            'name' => 'Brazilian Real',
            'code' => 'BRL',
            'symbol' => 'R$'
        ]);
    }
}
