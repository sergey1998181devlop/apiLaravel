<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cdp_loyal_checks', function (Blueprint $table) {
            $table->timestamp('check_data_start')->after('bonus_id')->nullable();
            $table->integer('check_sum')->after('check_data_start')->nullable();
            $table->string('status')->after('check_sum')->nullable();
            $table->timestamp('check_data_end')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cdp_loyal_checks', function (Blueprint $table) {
            $table->dropColumn('check_data_start');
            $table->dropColumn('check_sum');
            $table->dropColumn('status');
            $table->dropColumn('check_data_end');
        });
    }
};
