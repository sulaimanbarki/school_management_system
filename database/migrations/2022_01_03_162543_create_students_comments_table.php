<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_comments', function (Blueprint $table) {
            $table->id();
            $table->string('studentid', 20);
            $table->foreign('studentid')->references('studentid')->on('studentinfo');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->date('date');
            $table->string('description', 255);
            $table->integer('classid')->unsigned();
            $table->foreign('classid')->references('C_id')->on('classes');
            $table->integer('sectionid')->unsigned();
            $table->foreign('sectionid')->references('Sec_ID')->on('Sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students_comments');
    }
}
