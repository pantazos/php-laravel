<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;

class AddPromoCodePermissions extends Migration
{
    public function up()
    {
        $promo_code_permissions = [
            [
                'title' => 'promo_code_access',
            ],
            [
                'title' => 'promo_code_create',
            ],
            [
                'title' => 'promo_code_edit',
            ],
            [
                'title' => 'promo_code_show',
            ],
            [
                'title' => 'promo_code_delete',
            ],
        ];
        Permission::insert($promo_code_permissions);

        $admin_permissions = Permission::all();
        Role::byKey(Role::ADMIN)->firstOrFail()->permissions()->sync($admin_permissions->pluck('id'));
    }
}
