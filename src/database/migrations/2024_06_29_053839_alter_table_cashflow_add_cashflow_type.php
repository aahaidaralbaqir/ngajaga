<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCashflowAddCashflowType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashflows', function (Blueprint $table) {
            $table->string('cashflow_type', 10)->nullable(false)->default('')->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashflows', function (Blueprint $table) {
            $table->dropColumn('cashflow_type');
        });
    }
}
