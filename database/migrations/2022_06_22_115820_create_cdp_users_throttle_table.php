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
        Schema::create('cdp_users_throttle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->string('ip_address')->nullable()->index();
            $table->integer('attempts')->default(0);
            $table->timestamp('last_attempt_at')->nullable();
            $table->boolean('is_suspended')->default(0);
            $table->timestamp('suspended_at')->nullable();
            $table->boolean('is_banned')->default(0);
            $table->timestamp('banned_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cdp_users_throttle');
    }
};
