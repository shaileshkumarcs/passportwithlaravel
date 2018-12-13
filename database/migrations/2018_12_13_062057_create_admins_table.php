<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('login_id')->unsigned()->unique();
            $table->string('v_first_name');
            $table->string('v_last_name');
            $table->string('v_phone')->unique()->nullable();
            $table->string('v_email')->unique()->nullable();
            $table->string('v_image_url')->nullable();
            $table->string('v_coverpic_url')->nullable();
            $table->string('v_address')->nullable();
            $table->string('v_city')->nullable();
            $table->string('v_state')->nullable();
            $table->string('v_country')->nullable();
            $table->string('v_pincode')->nullable();
            $table->string('v_business_name')->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });

        Schema::table('admins', function($table) {
            $table->foreign('login_id')->references('id')->on('logins')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
