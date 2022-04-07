<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentpersonaldevelopmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentpersonaldevelopments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pdid')->unsigned();
            $table->foreign('pdid')->references('id')->on('personal_developments');
            $table->integer('classid')->unsigned();
            $table->foreign('classid')->references('C_id')->on('classes');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->string('isactive', 10);
            $table->string('status', 50);
            $table->date('date');
            $table->integer('sequence');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('studentpersonaldevelopments');
    }
}
