<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Classes', function (Blueprint $table) {
            $table->increments('C_id');
            // $table->foreignId('Class')->nullable()->index();
            $table->string('ClassName', 45)->nullable();
            $table->text('Isdisplay')->nullable();
            $table->tinyInteger('Sequence');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');


            //$table->integer('last_activity')->index();
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
