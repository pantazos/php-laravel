<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoCodesTable extends Migration
{
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('enabled')->default(0);
            $table->string('code')->unique();
            $table->string('type');
            $table->float('discount', 5, 2);
            $table->datetime('expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
