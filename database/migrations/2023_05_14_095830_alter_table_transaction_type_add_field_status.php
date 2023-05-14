<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTransactionTypeAddFieldStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('transaction_type', function(Blueprint $table) {
			$table->boolean('status')->default(FALSE)->after('banner');
			$table->renameColumn('banner', 'icon');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('transaction_type', function(Blueprint $table) {
			$table->renameColumn('icon', 'banner');
			$table->dropColumn('status');
		});
	}
}
