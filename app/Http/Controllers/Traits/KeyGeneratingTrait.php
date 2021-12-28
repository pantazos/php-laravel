<?php

namespace App\Http\Controllers\Traits;

use Hashids\Hashids;

trait KeyGeneratingTrait
{
    public function generateKey($item): string
    {
        // Generate random and unique key for the request
        $hashids = new Hashids($item, 10);
        $uniqueNumber = (int)(microtime(true) * 10000);

        return $hashids->encode($uniqueNumber);
    }
}
