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
        Schema::create('cdp_loyal_bonus_logs', function (Blueprint $table) {
            $table->bigIncrements('id')->unique()->unsigned()->index();
            $table->string('bonus_transaction')->nullable();
            $table->timestamp('bonus_date')->nullable();
            $table->unsignedBigInteger('bonus_id')->index();
            $table->unsignedBigInteger('bonus_type')->unsigned()->index();
            $table->unsignedBigInteger('user_id')->unsigned()->index();
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
        Schema::dropIfExists('cdp_loyal_bonus_logs');
    }
};
