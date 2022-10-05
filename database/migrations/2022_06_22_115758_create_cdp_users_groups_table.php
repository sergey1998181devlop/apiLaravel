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
        Schema::create('cdp_user_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('code')->nullable()->index();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('cdp_users_groups', function(Blueprint $table)
        {
            $table->integer('user_id')->unsigned();
            $table->integer('user_group_id')->unsigned();
            $table->primary(['user_id', 'user_group_id'], 'cdp_user_group');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cdp_user_groups');
        Schema::dropIfExists('cdp_users_groups');
    }
};
