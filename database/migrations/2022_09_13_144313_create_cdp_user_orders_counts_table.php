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
        Schema::create('cdp_user_orders_counts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->boolean('count_activated');
                $table->string('count_unactivated');
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
        Schema::dropIfExists('cdp_user_orders_counts');
    }
};
