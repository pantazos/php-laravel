<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            PermissionRoleTableSeeder::class,
            StatusesTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            CurrenciesTableSeeder::class,
            PaymentMethodsTableSeeder::class,
            PaymentSettingsTableSeeder::class
        ]);
    }
}
