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
        Schema::create('cdp_users_orders', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->index();
            $table->string('product_price');
            $table->string('product_type');
            $table->timestamp('product_duration')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->string('product_title');
            $table->boolean('is_activated')->default(FALSE);
            $table->date('activated_at')->nullable();
            $table->foreign('id')->references('id')->on('cdp_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cdp_users_orders');
    }
};
