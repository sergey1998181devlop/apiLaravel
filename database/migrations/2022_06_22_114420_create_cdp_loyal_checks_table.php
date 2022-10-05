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
        Schema::create('cdp_loyal_checks', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->index();
            $table->integer('user_id');
            $table->integer('mall_id');
            $table->unsignedBigInteger('bonus_id');
            $table->foreign('bonus_id')->references('bonus_id')->on('cdp_loyal_bonus_logs');
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
        Schema::dropIfExists('cdp_loyal_checks');
    }
};
