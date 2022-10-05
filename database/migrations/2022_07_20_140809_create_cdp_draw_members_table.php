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
        Schema::create('cdp_draw_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('draw_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('mall_id');
            $table->foreign('mall_id')->references('mall_id')->on('cdp_malls');
            $table->foreign('draw_id')->references('id')->on('cdp_draws');
            $table->foreign('user_id')->references('id')->on('cdp_users');
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
        Schema::dropIfExists('cdp_draw_members');
    }
};
