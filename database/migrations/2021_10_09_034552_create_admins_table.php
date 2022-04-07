<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('fname');
            $table->string('cnic', 20);
            $table->string('gender', 20);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone1', 15);
            $table->string('phone2', 15)->nullable();
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->date('joindate');
            $table->boolean('isactive');
            // $table->date('employeedepartment');
            $table->integer('departmentid')->unsigned();
            $table->foreign('departmentid')->references('id')->on('departments');
            $table->integer('scaleid')->unsigned();
            $table->foreign('scaleid')->references('id')->on('scales');
            $table->boolean('fixedsalary');
            $table->rememberToken();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->foreignId('current_team_id')->nullable();
            // $table->timestamps();
            $table->integer('roleid')->unsigned();
            $table->foreign('roleid')->references('RoleId')->on('roles');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->string('busnumber', 20)->nullable();
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
