<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPaymentSettingsTable extends Migration
{
    public function up()
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id', 'currency_fk_4839006')->references('id')->on('currencies');
        });
    }
}
