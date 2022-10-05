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
        Schema::create('cdp_users_sessions', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->index();
            $table->string('session_token');
            $table->timestamp('expiration_session');
            $table->foreign('id')->references('id')->on('cdp_users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cdp_users_sessions');
    }
};
