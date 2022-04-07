<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentWiseSchlorshipHeads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('Studentscholarshipwisesubheads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subheadid')->unsigned();
            $table->integer('amountParentage');
            $table->string('studentid', 20);
            $table->foreign('studentid')->references('studentid')->on('studentinfo');
            $table->foreign('subheadid')->references('id')->on('feesubheads');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->integer('scholarshipid')->unsigned();
            $table->foreign('scholarshipid')->references('id')->on('scholarships');
            $table->integer('sessionid')->unsigned();
            $table->foreign('sessionid')->references('id')->on('academicsessions');
            $table->date('issuedate');
            $table->date('lastdate');
            $table->integer('sequence');
            $table->string('isactive', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
