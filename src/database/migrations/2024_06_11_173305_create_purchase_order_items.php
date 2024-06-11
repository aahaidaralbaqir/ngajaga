<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_order_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty');
            $table->integer('price');
            $table->integer('received_qty');
            $table->integer('received_price');
            $table->integer('total_price');
            $table->string('notes', 255)->nullable();
            $table->integer('accept_stock')->default(1);
            $table->integer('update_product_price')->default(2);
            $table->timestamps();

            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE purchase_order_items MODIFY created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
        DB::statement('ALTER TABLE purchase_order_items MODIFY updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_items');
    }
}
