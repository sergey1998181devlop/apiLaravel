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
        Schema::create('cdp_email_notes', function (Blueprint $table) {
            $table->bigIncrements('id')->unique()->unsigned()->index();
            $table->unsignedBigInteger('message_id');
            $table->unsignedBigInteger('send_type');
            $table->unsignedBigInteger('mall_id')->nullable();
            $table->foreign('mall_id')->references('mall_id')->on('cdp_malls')->onDelete('cascade');
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
        Schema::dropIfExists('cdp_email_notes');
    }
};
