<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicsessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academicsessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Session');
            $table->integer('CampusID')->unsigned();
            $table->string('SessionType');
            $table->date('StartDate');
            $table->date('EndDate');
            $table->boolean('IsActive');
            $table->boolean('IsCurrent');
            $table->foreign('CampusID')->references('campusid')->on('configurations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academicsessions');
    }
}
