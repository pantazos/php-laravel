<?php

namespace App\Observers;

use App\Http\Controllers\Traits\KeyGeneratingTrait;
use App\Models\Service;

class ServiceObserver
{
    use KeyGeneratingTrait;

    public function creating(Service $service)
    {
        $service->key = $service->key ?: $this->generateKey($service);
    }
}
