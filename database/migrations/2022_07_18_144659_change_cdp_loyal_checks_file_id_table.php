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
            if (Schema::hasColumn('cdp_loyal_checks', 'file_id')) {
                $table->dropConstrainedForeignId('file_id');
            }
        });

        Schema::table('cdp_loyal_checks', function (Blueprint $table) {
            if (!Schema::hasColumn('cdp_loyal_checks', 'file_link')) {
                $table->string('file_link');
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
