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
        Schema::create('cdp_users', function (Blueprint $table) {
            $table->bigIncrements('id')->unique()->unsigned()->index();
            $table->string('name');
            $table->string('surname')->nullable();
            $table->unsignedBigInteger('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('sex')->nullable();
            $table->text('permissions')->nullable();
            $table->boolean('is_activated')->default(0);
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('last_seen')->nullable();
            $table->boolean('is_guest')->default(false);
            $table->unsignedBigInteger('mall_id')->nullable();
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
        Schema::dropIfExists('cdp_users');
    }
};
