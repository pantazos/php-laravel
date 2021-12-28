<?php

namespace App\Http\Controllers\Traits;

use Money\Currency;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;

trait MoneyTrait
{
    public function moneyFormat($amount, $currencySymbol): int
    {
        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);
        $money = $moneyParser->parse($amount, new Currency($currencySymbol));
        return $money->getAmount();
    }
}
