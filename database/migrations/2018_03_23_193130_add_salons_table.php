<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSalonsTable extends Migration
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

        Schema::table('users', function($table)
        {
            $table->dropColumn('salon_name');
            $table->dropColumn('salon_address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('salons');
    
        Schema::table('users', function($table)
        {
            $table->char('salon_name',20);
            $table->char('salon_address',20);
        });
    }

}
