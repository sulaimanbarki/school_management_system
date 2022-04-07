<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateClassWiseTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_wise_teachers', function (Blueprint $table) {
            $table->id();
            $table->integer('classid')->unsigned();
            $table->foreign('classid')->references('C_id')->on('classes');
            $table->integer('sectionid')->unsigned();
            $table->foreign('sectionid')->references('Sec_ID')->on('Sections');
            $table->bigInteger('empid')->unsigned();
            $table->foreign('empid')->references('id')->on('admins');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

            $table->unique(['classid', 'sectionid', 'empid', 'campusid']);
            $table->unique(['classid', 'sectionid']);
            $table->unique(['empid', 'campusid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_wise_teachers');
    }
}
