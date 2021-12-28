<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToServiceExtrasTable extends Migration
{
    public function up()
    {
        Schema::table('service_extras', function (Blueprint $table) {
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id', 'service_fk_4823215')->references('id')->on('services');
        });
    }
}
