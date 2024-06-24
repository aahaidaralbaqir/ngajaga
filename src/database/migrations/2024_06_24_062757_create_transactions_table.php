<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 10);
            $table->integer('price_total');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('customer_id')->nullable(false);
            $table->unsignedBigInteger('account_id')->nullable(false);
            // Foreign key constraints
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('account_id')->references('id')->on('accounts');
            // If you want to match the exact behavior of your SQL schema:
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            // Laravel's default behavior is usually sufficient:
            // $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
