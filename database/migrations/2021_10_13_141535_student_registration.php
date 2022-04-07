<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('StudentRegistrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('formid', 20);
            $table->string('studentname', 150);
            $table->string('fname', 100);
            $table->string('contact', 20);
            // $table->string('admissioninclass', 10);
            $table->integer('admissioninclass')->unsigned();
            $table->foreign('admissioninclass')->references('C_id')->on('classes');
            $table->date('date');
            // $table->string('academicsession', 20);
            $table->integer('academicsession')->unsigned();
            $table->foreign('academicsession')->references('id')->on('academicsessions');
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
        //
    }
}
