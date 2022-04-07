<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentWiseFeeCriterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentwisefeecriterias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->string('studentid', 20)->unique();
            $table->foreign('studentid')->references('studentid')->on('studentinfo');
            $table->integer('scholarshipid')->unsigned();
            $table->foreign('scholarshipid')->references('id')->on('scholarships');
            $table->integer('sessionid')->unsigned();
            $table->foreign('sessionid')->references('id')->on('academicsessions');
            $table->integer('sequence');
            $table->bigInteger('addedby')->unsigned();
            $table->foreign('addedby')->references('id')->on('admins');
            $table->date('allowedupto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_wise_fee_criterials');
    }
}
