<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return array_map(function($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }

    public function up()
    {
        if(!Schema::hasTable('service_user'))
        {
            Schema::create('service_user', function (Blueprint $table) {
                $table->integer('user_id')->unsigned();
                $table->integer('service_id')->unsigned();
                $table->integer('duration')->unsigned();
                $table->double('price');
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('service_id')->references('id')->on('services');
                $table->unique(['user_id','service_id'],'user_service_index');
            
                $table->foreign('user_id')->references('id')->on('users');
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
        if(Schema::hasTable('service_user'))
        {
            Schema::drop('service_user');
        }
        //Schema::rename('user_services','service_user');
    }
}
