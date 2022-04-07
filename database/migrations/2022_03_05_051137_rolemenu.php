<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Rolemenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_menu', function (Blueprint $table) {
            $table->increments('rm_id');
            $table->bigInteger('RoleId')->unsigned();
            // $table->foreign('RoleId')->references('RoleId')->on('roles');
            $table->string("parent_menu_name")->nullable();
            $table->string("parent_menu_link")->nullable();
            $table->string("child_menu_name")->nullable();
            $table->string("child_menu_link")->nullable();
            $table->string("parent_icon")->nullable();
            $table->string("child_icon")->nullable();
            $table->date("date");
            $table->timestamp("updated_at")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp("created_at")->default(DB::raw('CURRENT_TIMESTAMP'));
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
