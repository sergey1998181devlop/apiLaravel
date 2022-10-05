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
            if (!Schema::hasColumn('cdp_draws', 'big_image_link')) {
                $table->string('big_image_link');
            }
        });
        Schema::table('cdp_draws', function (Blueprint $table) {
            if (!Schema::hasColumn('cdp_draws', 'small_image_link')) {
                $table->string('small_image_link');
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
