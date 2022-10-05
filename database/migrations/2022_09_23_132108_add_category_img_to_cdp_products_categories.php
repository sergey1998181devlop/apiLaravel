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
        Schema::table('cdp_products_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('cdp_products_categories', 'category_image')) {
                $table->string('category_image');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cdp_products_categories', function (Blueprint $table) {
            //
        });
    }
};
