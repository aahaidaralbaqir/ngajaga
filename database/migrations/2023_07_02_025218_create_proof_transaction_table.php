<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProofTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proof_transaction', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('transaction_id')->notNull();
			$table->unsignedBigInteger('uploaded_by');
			$table->string('image', 255);
			$table->foreign('transaction_id')->references('id')->on('transaction');
			$table->foreign('uploaded_by')->references('id')->on('users');
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
        Schema::dropIfExists('proof_transaction');
    }
}
