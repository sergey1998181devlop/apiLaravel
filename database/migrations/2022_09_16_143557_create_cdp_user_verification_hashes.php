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
        Schema::create('cdp_user_verification_hashes', function (Blueprint $table) {
            $table->bigIncrements('id')->unique()->unsigned()->index();
            $table->string('hash');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('cdp_users')->onDelete('cascade');
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
        Schema::dropIfExists('cdp_user_verification_hashes');
    }
};
