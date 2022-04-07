<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentcomments', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('studentid', 20);
            $table->foreign('studentid')->references('studentid')->on('studentinfo');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->dateTime('date');
            $table->string('description');
            $table->integer('classid')->unsigned();
            $table->foreign('classid')->references('C_id')->on('classes');
            $table->integer('sectionid')->unsigned();
            $table->foreign('sectionid')->references('Sec_ID')->on('Sections');
            $table->integer('sessionid')->unsigned();
            $table->foreign('sessionid')->references('id')->on('academicsessions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_comments');
    }
}
