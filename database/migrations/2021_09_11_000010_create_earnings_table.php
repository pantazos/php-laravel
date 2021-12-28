<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarningsTable extends Migration
{
    public function up()
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bookings_count');
            $table->decimal('total_earning', 15, 2);
            $table->decimal('admin_earning', 15, 2);
            $table->decimal('provider_earning', 15, 2);
            $table->decimal('total_tax', 15, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
