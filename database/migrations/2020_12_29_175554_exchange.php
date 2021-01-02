<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Exchange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('baseCurrency');
            $table->string('quoteCurrency');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->string('user_id');
            $table->string('rate');
            $table->float('baseCurrencyAmount');
            $table->float('quoteCurrencyAmount');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange');
    }
}
