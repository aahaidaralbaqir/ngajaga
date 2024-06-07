<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('sku', 10);
            $table->text('description')->nullable();
            $table->integer('selling_price');
            $table->integer('buy_price');
            $table->unsignedBigInteger('barcode_id')->nullable();
            $table->tinyInteger('unit');
            $table->tinyInteger('min_qty')->nullable();
            $table->tinyInteger('notify_when_low_quota')->default(0);
            $table->unsignedBigInteger('shelf_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();

            $table->foreign('shelf_id')->references('id')->on('shelf');
            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
