<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPromoCodeRelationToBooking extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('promo_code_id')->nullable();
            $table->foreign('promo_code_id', 'promo_code_fk_4922035')->references('id')->on('promo_codes');
        });
    }
}
