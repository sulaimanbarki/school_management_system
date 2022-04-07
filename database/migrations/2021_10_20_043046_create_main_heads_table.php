<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainHeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mainheads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mainhead', 50);
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->boolean('isactive');
            $table->string('isdefault', 10);
            $table->integer('sequence');
            $table->bigInteger('addedby')->unsigned();
            $table->foreign('addedby')->references('id')->on('admins');
            $table->date('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_heads');
    }
}
