<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryPromoCodePivotTable extends Migration
{
    public function up()
    {
        Schema::create('category_promo_code', function (Blueprint $table) {
            $table->unsignedBigInteger('promo_code_id');
            $table->foreign('promo_code_id', 'promo_code_id_fk_4883903')->references('id')->on('promo_codes')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id', 'category_id_fk_4883903')->references('id')->on('categories')->onDelete('cascade');
        });
    }
}
