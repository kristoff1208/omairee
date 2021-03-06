<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserJisha extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_jisha', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->unsigned()->comment('User ID');
            $table->integer('jisha_id')->nullable()->unsigned()->comment('jisha ID');
            $table->integer('coin')->default(0);
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
        //
        Schema::dropIfExists('user_jisha');
    }
}
