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
        Schema::create('cdp_draws', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mall_id');
            $table->foreign('mall_id')->references('mall_id')->on('cdp_malls');
            $table->string('title');
            $table->string('description');
            $table->string('date_start');
            $table->string('date_end');
            $table->unsignedBigInteger('bonus_price');
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
        Schema::dropIfExists('cdp_draws');
    }
};
