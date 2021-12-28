<?php

namespace App\Observers;

use App\Http\Controllers\Traits\KeyGeneratingTrait;
use App\Models\Role;

class RoleObserver
{
    use KeyGeneratingTrait;

    public function creating(Role $role)
    {
        $role->key = $role->key ?: $this->generateKey($role);
    }
}
