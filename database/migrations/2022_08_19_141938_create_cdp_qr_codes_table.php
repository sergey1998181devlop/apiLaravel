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
        Schema::create('cdp_qr_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->boolean('is_activated');
            $table->string('link');
            $table->string('hash');
            $table->foreign('order_id')->references('id')->on('cdp_users_orders');
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
        Schema::dropIfExists('cdp_qr_codes');
    }
};
