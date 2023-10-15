<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTableSturctureActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activity', function (Blueprint $table) {
            $table->integer('start_time')->notNull()->default(0)->after('name');
            $table->integer('end_time')->notNull()->default(0)->after('start_time');
            $table->boolean('recurring')->default(false)->after('end_time');
            $table->integer('recurring_days')->default(0)->after('recurring');
            $table->string('leader', 100)->notNull()->after('recurring_days');
            $table->boolean('show_landing_page')->default(false);
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activity', function (Blueprint $table) {
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('recurring');
            $table->dropColumn('recurring_days');
            $table->dropColumn('leader');
            $table->dropColumn('show_landing_page');
        });
    }
}
