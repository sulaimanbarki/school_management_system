<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EmployeeMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('emp_menu', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empid')->unsigned();
            $table->foreign('empid')->references('id')->on('admins');
            $table->string("parent_menu_name")->nullable();
            $table->string("parent_menu_link")->nullable();
            $table->string("child_menu_name")->nullable();
            $table->string("child_menu_link")->nullable();
            $table->string("parent_icon")->nullable();
            $table->string("child_icon")->nullable();
            $table->date("date");
            $table->integer("amount");
            $table->string("type")->nullable();
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
