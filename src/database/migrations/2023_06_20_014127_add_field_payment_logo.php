<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldPaymentLogo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_type', function (Blueprint $table) {
            $table->tinyInteger('id_parent')->after('name')->notNull()->default(0);
            $table->string('payment_logo', 200)->after('id_parent')->notNull();
            $table->string('value', 20)->after('id_parent')->notNull();
            $table->tinyInteger('expired_time')->after('payment_logo')->notNull()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_type', function (Blueprint $table) {
            $table->dropColumn('id_parent');
            $table->dropColumn('payment_logo');
            $table->dropColumn('expired_time');
        });
    }
}
