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
        Schema::create('cdp_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('visible')->default(true);
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('price')->nullable();
            $table->string('product_image')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sort_product');
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
        Schema::dropIfExists('cdp_products');
    }
};
