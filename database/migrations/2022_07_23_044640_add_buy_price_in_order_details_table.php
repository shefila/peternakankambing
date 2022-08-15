<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->unsignedBigInteger('buy_price')->nullable();
        });
    }

    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            //
        });
    }
};
