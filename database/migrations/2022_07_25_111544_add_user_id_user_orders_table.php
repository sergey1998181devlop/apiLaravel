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
        Schema::table('cdp_users_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('cdp_users_orders', 'user_id')) {
                $table->dropConstrainedForeignId('id');
            }
        });
        Schema::table('cdp_users_orders', function (Blueprint $table) {
            if (!Schema::hasColumn('cdp_users_orders', 'file_link')) {
                $table->id();
                $table->string('file_link');
                $table->string('data_purchase');
            }
        });
        Schema::table('cdp_users_orders', function (Blueprint $table) {
        if (!Schema::hasColumn('cdp_users_orders', 'user_id')) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('cdp_users');
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
