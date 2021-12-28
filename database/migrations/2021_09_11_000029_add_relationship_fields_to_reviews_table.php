<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToReviewsTable extends Migration
{
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id');
            $table->foreign('booking_id', 'booking_fk_4704063')->references('id')->on('bookings');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id', 'service_fk_4704062')->references('id')->on('services');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id', 'customer_fk_4704067')->references('id')->on('users');
        });
    }
}
