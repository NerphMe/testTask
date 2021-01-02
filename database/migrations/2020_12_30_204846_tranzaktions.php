<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tranzaktions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('transactions', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('currency');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->string('user_id');
            $table->float('amount');
            $table->string('type');

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
