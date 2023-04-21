<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedInteger('id_transaction_type');
			$table->string('order_id', 20);
			$table->integer('paid_amount');
			$table->integer('va_number');
			$table->enum('transaction_status', [1, 2, 3, 4, 5, 6]);
			$table->string('redirect_payment', 255)->nullable();
			$table->timestamp('created_at')->nullable();
			$table->timestamp('updated_at')->nullable();

			$table->foreign('id_transaction_type')->references('id')->on('transaction_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
