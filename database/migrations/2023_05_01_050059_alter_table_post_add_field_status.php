<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constant\Constant;

class AlterTablePostAddFieldStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post', function(Blueprint $table) {
            $table->integer('status')->after('banner')->default(Constant::STATUS_DRAFT);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post', function(Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
