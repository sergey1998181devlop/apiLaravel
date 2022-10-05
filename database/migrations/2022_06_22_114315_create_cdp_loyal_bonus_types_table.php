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
        Schema::create('cdp_loyal_bonus_types', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->index();
            $table->unsignedBigInteger('bonus_type')->unsigned()->index();
            $table->foreign('bonus_type')->references('bonus_type')->on('cdp_loyal_bonus_logs');
            $table->string('bonus_description');
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
        Schema::dropIfExists('cdp_loyal_bonus_types');
    }
};
