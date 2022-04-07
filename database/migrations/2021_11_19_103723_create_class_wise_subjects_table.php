<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassWiseSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classwisesubjects', function (Blueprint $table) {
            $table->id();
            $table->integer('classid')->unsigned();
            $table->foreign('classid')->references('C_id')->on('classes');
            $table->bigInteger('subjectid')->unsigned();
            $table->foreign('subjectid')->references('id')->on('subjects');
            $table->boolean('isdisplay');
            $table->integer('theorymarks');
            $table->integer('practicalmarks');
            $table->integer('passingmarks');
            $table->date('date');
            $table->integer('transcriptsequence');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classwisesubjects');
    }
}
