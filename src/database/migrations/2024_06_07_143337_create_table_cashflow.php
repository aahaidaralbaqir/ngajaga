<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCashflow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashflows', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->unsignedSmallInteger('account_id');
            $table->mediumInteger('amount');
            $table->unsignedSmallInteger('created_by');
            $table->string('description', 100);
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cashflows');
    }
}
