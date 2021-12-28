<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('category_user', function (Blueprint $table) {
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id', 'provider_id_fk_4704014')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id', 'category_id_fk_4704014')->references('id')->on('categories')->onDelete('cascade');
        });
    }
}
