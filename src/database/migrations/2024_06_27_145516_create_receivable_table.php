<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivableTable extends Migration
{
    public function up()
    {
        Schema::create('receivable', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('debt_id');
            $table->unsignedSmallInteger('created_by');
            $table->unsignedBigInteger('amount');
            $table->unsignedBigInteger('receivable_date');
            $table->timestamp('created_at')->default(now());
            $table->timestamp('updated_at')->default(now())->onUpdate(now());

            // Foreign keys
            $table->foreign('debt_id')->references('id')->on('debt');
            $table->foreign('created_by')->references('id')->on('users');

            // Indexes
            $table->index('debt_id');
            $table->index('created_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('receivable');
    }
}
