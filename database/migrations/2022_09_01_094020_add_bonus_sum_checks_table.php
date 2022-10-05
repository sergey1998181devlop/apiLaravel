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
            if (!Schema::hasColumn('cdp_loyal_checks', 'bonus_sum')) {
                $table->unsignedBigInteger('bonus_sum');
            }
        });
        Schema::table('cdp_products', function (Blueprint $table) {
            if (!Schema::hasColumn('cdp_products', 'october_id')) {
                $table->unsignedBigInteger('october_id');
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
