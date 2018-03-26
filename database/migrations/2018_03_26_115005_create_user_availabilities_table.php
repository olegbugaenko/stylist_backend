<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('user_availabilities'))
        {
            Schema::create('user_availabilities',function(Blueprint $table){
                $table->integer('user_id')->unsigned();
                $table->integer('day_id')->unsigned();
                $table->integer('from')->unsigned();
                $table->integer('to')->unsigned();
                $table->boolean('is_free');
                
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users');
                $table->unique(['user_id','day_id'],'user_availability_index');
            });
        }
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_availabilities');
    }
}
