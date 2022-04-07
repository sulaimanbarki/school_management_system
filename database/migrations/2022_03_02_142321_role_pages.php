<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RolePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_pages', function (Blueprint $table) {
            $table->increments('role_page_id');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('RoleId')->on('roles');
            $table->integer('pages_id')->unsigned();
            $table->foreign('pages_id')->references('page_id')->on('pages');
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
