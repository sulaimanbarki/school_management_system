<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTimeTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_tables', function (Blueprint $table) {
            $table->id();
            $table->integer('classid')->unsigned();
            $table->foreign('classid')->references('C_id')->on('classes');
            $table->integer('sectionid')->unsigned();
            $table->foreign('sectionid')->references('Sec_ID')->on('Sections');
            $table->bigInteger('subjectid')->unsigned();
            $table->foreign('subjectid')->references('id')->on('subjects');
            $table->bigInteger('empid')->unsigned();
            $table->foreign('empid')->references('id')->on('admins');
            $table->bigInteger('timeid')->unsigned();
            $table->foreign('timeid')->references('id')->on('times');
            $table->bigInteger('locationid')->unsigned();
            $table->foreign('locationid')->references('id')->on('locations');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->smallInteger('sequence');
            $table->smallInteger('isdisplay');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

            $table->unique(['classid', 'sectionid', 'subjectid','campusid'], 'compositeKey');
            $table->unique(['empid', 'timeid','campusid'], 'compositeKey1');
            $table->unique(['locationid', 'timeid','campusid'], 'compositeKey2');
            $table->unique(['classid', 'sectionid','campusid','timeid'], 'compositeKey3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_tables');
    }
}
