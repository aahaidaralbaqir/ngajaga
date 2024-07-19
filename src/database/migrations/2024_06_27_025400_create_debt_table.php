<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDebtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debt', function (Blueprint $table) {
            $table->unsignedSmallInteger('id', true);
            $table->mediumInteger('amount');
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedSmallInteger('created_by');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('debt');
    }
}
