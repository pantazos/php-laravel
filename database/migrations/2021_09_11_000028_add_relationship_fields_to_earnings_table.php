<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEarningsTable extends Migration
{
    public function up()
    {
        Schema::table('earnings', function (Blueprint $table) {
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id', 'provider_fk_4704076')->references('id')->on('users');
        });
    }
}
