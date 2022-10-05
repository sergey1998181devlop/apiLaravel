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
        Schema::create('malls_credentials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mall_id')->nullable();
            $table->string('sms_user');
            $table->string('sms_password');
            $table->string('mail_user');
            $table->string('mail_password');
            $table->foreign('mall_id')->references('mall_id')->on('cdp_malls');
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
        Schema::dropIfExists('malls_credentials');
    }
};
