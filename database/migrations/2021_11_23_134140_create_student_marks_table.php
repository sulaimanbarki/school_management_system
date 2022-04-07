<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentmarks', function (Blueprint $table) {
            $table->id();
            $table->string('studentid', 20);
            $table->foreign('studentid')->references('studentid')->on('studentinfo');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->integer('classid')->unsigned();
            $table->foreign('classid')->references('C_id')->on('classes');
            $table->integer('sectionid')->unsigned();
            $table->foreign('sectionid')->references('Sec_ID')->on('Sections');
            $table->bigInteger('subjectid')->unsigned();
            $table->foreign('subjectid')->references('id')->on('subjects');
            $table->smallInteger('total_marks_theory');
            $table->smallInteger('obtain_marks_theory');
            $table->boolean('isAbsenct_theory');
            $table->smallInteger('total_marks_practical');
            $table->smallInteger('obtain_marks_practical');
            $table->boolean('isAbsenct_practical');
            $table->date('date');
            $table->bigInteger('termid')->unsigned();
            $table->foreign('termid')->references('id')->on('termnames');
            $table->integer('sessionid')->unsigned();
            $table->foreign('sessionid')->references('id')->on('academicsessions');
            $table->boolean('attempted_status');
            $table->smallInteger('position');
            $table->smallInteger('addedby');
            $table->dateTime('timestampss');
            $table->boolean('isFinalize');
            $table->string('pcname', 50);
            $table->string('macaddress', 100);
            $table->string('ipaddress', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_marks');
    }
}
