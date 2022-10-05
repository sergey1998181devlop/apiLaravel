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
        Schema::table('cdp_draws', function (Blueprint $table) {
            if (Schema::hasColumn('cdp_draws', 'date_start')) {
                $table->dropColumn('date_start');
            }
        });
        Schema::table('cdp_draws', function (Blueprint $table) {
            if (!Schema::hasColumn('cdp_draws', 'date_start')) {
                $table->timestamp('date_start');
            }
        });
        Schema::table('cdp_draws', function (Blueprint $table) {
            if (Schema::hasColumn('cdp_draws', 'date_end')) {
                $table->dropColumn('date_end');
            }
        });
        Schema::table('cdp_draws', function (Blueprint $table) {
            if (!Schema::hasColumn('cdp_draws', 'date_end')) {
                $table->timestamp('date_end');
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
        //
    }
};
