<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RolesLogins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_logins', function(Blueprint $table)
        {
            $table->integer('roles_id')->unsigned()->nullable();
            $table->foreign('roles_id')->references('id')
                    ->on('roles')->onDelete('cascade');

            $table->integer('logins_id')->unsigned()->nullable();
            $table->foreign('logins_id')->references('id')
                    ->on('logins')->onDelete('cascade');
                    
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
        Schema::dropIfExists('roles_logins');
    }
}
