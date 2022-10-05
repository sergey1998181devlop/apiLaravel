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
        Schema::create('cdp_products_catalogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('visible')->default(true);
            $table->unsignedBigInteger('mall_id');
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
        Schema::dropIfExists('cdp_products_catalogs');
    }
};
