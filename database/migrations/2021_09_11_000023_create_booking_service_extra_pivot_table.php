<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingServiceExtraPivotTable extends Migration
{
    public function up()
    {
        Schema::create('booking_service_extra', function (Blueprint $table) {
            $table->unsignedBigInteger('booking_id');
            $table->foreign('booking_id', 'booking_id_fk_4839461')->references('id')->on('bookings')->onDelete('cascade');
            $table->unsignedBigInteger('service_extra_id');
            $table->foreign('service_extra_id', 'service_extra_id_fk_4839461')->references('id')->on('service_extras')->onDelete('cascade');
        });
    }
}
