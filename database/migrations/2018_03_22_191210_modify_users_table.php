<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users',function($table){
            $table->char('phonenumber',14);
            $table->char('last_name',20);
            $table->char('salon_name',20);
            $table->char('salon_address',20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users',function($table){
            $table->dropColumn('phonenumber');
            $table->dropColumn('last_name');
            $table->dropColumn('salon_name');
            $table->dropColumn('salon_address');
        });
    }
}
