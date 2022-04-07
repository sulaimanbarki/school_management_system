<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('formid');
            $table->string('studentid', 20)->unique();
            $table->integer('registrationid');
            $table->integer('campusid');
            $table->string('studentname');
            $table->string('fathername');
            $table->date('dob');
            $table->string('gender', 20);
            $table->string('status', 50);
            $table->integer('admissioninclass')->unsigned();
            $table->foreign('admissioninclass')->references('C_id')->on('classes');
            $table->integer('admissioninsection')->unsigned();
            $table->foreign('admissioninsection')->references('Sec_ID')->on('Sections');
            $table->date('date');
            $table->integer('session')->unsigned();
            $table->foreign('session')->references('id')->on('academicsessions');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('fathercontact', 20);
            $table->string('contact1', 20)->nullable();
            $table->string('contactwhatsapp', 20)->nullable();
            $table->string('cnic', 20)->nullable();
            $table->string('formb', 20)->nullable();
            $table->string('occupation', 50)->nullable();
            $table->string('transportstatus', 5)->nullable();
            $table->string('busnumber', 20)->nullable();
            $table->string('picturepath')->nullable();
            $table->string('admissionremarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_infos');
    }
}
