<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->unique()->index();
            $table->string('title')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        $roles = [
            [
                'key' => Role::ADMIN,
                'title' => 'Admin',
            ],
            [
                'key' => Role::CUSTOMER,
                'title' => 'Customer',
            ],
            [
                'key' => Role::PROVIDER,
                'title' => 'Provider',
            ],
        ];

        Role::insert($roles);
    }
}
