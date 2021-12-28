<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id', 'customer_fk_4704057')->references('id')->on('users');
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->foreign('provider_id', 'provider_fk_4704058')->references('id')->on('users');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id', 'service_fk_4704044')->references('id')->on('services');
            $table->unsignedBigInteger('status_id');
            $table->foreign('status_id', 'status_fk_4704045')->references('id')->on('statuses');
        });
    }
}
