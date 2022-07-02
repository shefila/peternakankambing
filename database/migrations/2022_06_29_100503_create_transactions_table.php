<?php

use App\Models\Saving;
use App\Models\Wallet;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Wallet::class);
            $table->foreignIdFor(Saving::class)->nullable();
            $table->unsignedBigInteger('amount');
            $table->enum('category', ['buy', 'deposit', 'withdraw']);
            $table->string('payment_proof')->nullable();
            $table->enum('status',['pending','waiting approval','success','failed','cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
