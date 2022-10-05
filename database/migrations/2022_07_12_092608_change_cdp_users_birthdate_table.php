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
        Schema::table('cdp_users', function (Blueprint $table) {
            if (Schema::hasColumn('cdp_users', 'birthdate')) {
                $table->dropColumn('birthdate');
            }
        });
        Schema::table('cdp_users', function (Blueprint $table) {
            if (!Schema::hasColumn('cdp_users', 'birthdate')) {
                $table->string('birthdate');
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
