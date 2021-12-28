<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoCodeServicePivotTable extends Migration
{
    public function up()
    {
        Schema::create('promo_code_service', function (Blueprint $table) {
            $table->unsignedBigInteger('promo_code_id');
            $table->foreign('promo_code_id', 'promo_code_id_fk_4883904')->references('id')->on('promo_codes')->onDelete('cascade');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id', 'service_id_fk_4883904')->references('id')->on('services')->onDelete('cascade');
        });
    }
}
