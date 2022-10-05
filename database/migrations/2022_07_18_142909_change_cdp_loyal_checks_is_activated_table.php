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
            if (Schema::hasColumn('cdp_loyal_checks', 'is_activated')) {
                $table->dropColumn('is_activated');
            }
        });

        Schema::table('cdp_loyal_checks', function (Blueprint $table) {
            if (!Schema::hasColumn('cdp_loyal_checks', 'is_activated')) {
                $table->boolean('is_activated')->default(FALSE);
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
