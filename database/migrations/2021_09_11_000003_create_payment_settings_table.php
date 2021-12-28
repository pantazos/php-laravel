<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('tax_enabled')->default(0);
            $table->float('tax_percentage', 5, 2);
            $table->timestamps();
        });
    }
}
