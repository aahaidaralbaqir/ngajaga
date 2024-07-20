<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->mediumInteger('id', true);
            $table->string('name', 50);
            $table->string('sku', 10);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('shelf_id')->nullable(false);
            $table->unsignedSmallInteger('category_id')->nullable(false);
            $table->unsignedSmallInteger('updated_by');
            $table->timestamps();

            $table->foreign('shelf_id')->references('id')->on('shelf');
            $table->foreign('category_id')->references('id')->on('category');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        DB::statement('ALTER TABLE products MODIFY created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
        DB::statement('ALTER TABLE products MODIFY updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
