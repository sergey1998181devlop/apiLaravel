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
            if (Schema::hasColumn('cdp_loyal_checks', 'bonus_id')) {
                $table->dropConstrainedForeignId('bonus_id');
            }
        });

        Schema::table('cdp_loyal_bonus_logs', function (Blueprint $table) {
            if (Schema::hasColumn('cdp_loyal_bonus_logs', 'bonus_id')) {
                $table->dropColumn('bonus_id');
                $table->unsignedBigInteger('check_id')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
