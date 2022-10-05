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
        Schema::table('cdp_loyal_bonus_logs', function (Blueprint $table) {
            $table->string('bonus_description')->after('user_id')->nullable();
            $table->string('payment_status')->after('bonus_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cdp_loyal_bonus_logs', function (Blueprint $table) {
            $table->dropColumn('bonus_description');
            $table->dropColumn('payment_status');
        });
    }
};
