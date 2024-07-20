<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->unsignedBigInteger('transaction_id');
            $table->mediumInteger('product_id');
            $table->unsignedBigInteger('unit');
            $table->integer('qty');

            // Foreign key constraints
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
}
