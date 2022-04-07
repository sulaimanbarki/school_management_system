<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ClassWiseSection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ClassWiseSection', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('Sequence');
            $table->date('Date');
            $table->boolean('isDisplay');
            $table->integer('campusid')->unsigned();
            $table->integer('ClassID')->unsigned();
            $table->integer('SectionID')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->foreign('ClassID')->references('C_id')->on('Classes');
            $table->foreign('SectionID')->references('Sec_ID')->on('Sections');
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
