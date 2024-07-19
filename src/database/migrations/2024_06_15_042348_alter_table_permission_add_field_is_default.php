<?php

use App\Constant\Constant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePermissionAddFieldIsDefault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permission', function (Blueprint $table) {
            $table->unsignedSmallInteger('is_default')->nullable(false)->default(Constant::OPTION_TRUE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission', function (Blueprint $table) {
            $table->dropColumn('is_default');
        }); 
    }
}
