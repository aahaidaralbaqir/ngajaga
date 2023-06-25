<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FundDistribution extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_distribution', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('beneficiary_id'); 
			$table->unsignedBigInteger('transaction_id');
			$table->text('description')->notNull();
			$table->foreign('beneficiary_id')->references('id')->on('beneficiary');
			$table->foreign('transaction_id')->references('id')->on('transaction');
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
		Schema::dropIfExists('fund_distribution');
    }
}
