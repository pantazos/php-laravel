<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->unique()->index();
            $table->datetime('booking_at');
            $table->string('notes')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('address_name');
            $table->string('address_details');
            $table->decimal('parts_cost', 15, 2)->nullable();
            $table->string('tax');
            $table->string('total');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
