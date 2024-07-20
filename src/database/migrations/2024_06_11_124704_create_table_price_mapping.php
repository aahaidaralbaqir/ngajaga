<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePriceMapping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_mapping', function (Blueprint $table) {
            $table->mediumInteger('id', true);
            $table->mediumInteger('product_id')->nullable();
            $table->smallInteger('unit')->nullable(false);
            $table->smallInteger('qty')->default(0);
            $table->smallInteger('conversion')->nullable(false);
            $table->integer('price')->nullable(false)->default(0);

            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::dropIfExists('price_mapping');
    }
}
