<?php

namespace App\Observers;

use App\Http\Controllers\Traits\KeyGeneratingTrait;
use App\Models\Role;
use App\Models\Status;

class StatusObserver
{
    use KeyGeneratingTrait;

    public function creating(Status $status)
    {
        $status->key = $status->key ?: $this->generateKey($status);
    }
}
