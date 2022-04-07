<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('page_id');
            $table->string('page_head', 100);
            $table->string('page_title', 100);
            $table->string('page_link', 255);
            $table->boolean('page_type');
            $table->integer('icon_id')->unsigned();
            $table->foreign('icon_id')->references('icon_id')->on('icons');
            $table->smallInteger('page_order')->default(100);
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
