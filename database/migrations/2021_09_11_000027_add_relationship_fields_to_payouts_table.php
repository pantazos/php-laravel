<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToPayoutsTable extends Migration
{
    public function up()
    {
        Schema::table('payouts', function (Blueprint $table) {
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id', 'provider_fk_4704086')->references('id')->on('users');
        });
    }
}
