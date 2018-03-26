<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('salons'))
        {
            Schema::create('salons', function (Blueprint $table) {
                $table->increments('user_id');
                $table->string('salon_name', 32);
                $table->string('salon_address', 255);
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
        if(Schema::hasTable('salons'))
        {
            Schema::drop('salons');
        }
    }

}
