<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'first_name'           => 'Belya',
                'last_name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'phone_number'   => '+1 222 333 444',
            ],
        ];

        // Create admin
        User::insert($users);
    }
}
