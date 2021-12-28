<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_fk_4704094')->references('id')->on('users');
            $table->unsignedBigInteger('payment_method_id');
            $table->foreign('payment_method_id', 'payment_method_fk_4838305')->references('id')->on('payment_methods');
        });
    }
}
