<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableInvoiceAddFieldPaymentTotal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_total')->nullable(false)->default(0)->after('purchase_order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_invoices', function (Blueprint $table) {
            $table->dropColumn('payment_total');
        });
    }
}
