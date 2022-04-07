<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeGenerationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feegenerations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('studentid', 20);
            $table->foreign('studentid')->references('studentid')->on('studentinfo');
            $table->integer('sessionid')->unsigned();
            $table->foreign('sessionid')->references('id')->on('academicsessions');
            $table->string('mainhead', 50);
            $table->integer('subheadid')->unsigned();
            $table->foreign('subheadid')->references('id')->on('feesubheads');
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            $table->integer('feeamount')->nullable();
            $table->string('description');
            $table->string('comment')->nullable();
            $table->boolean('ispaid');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->date('date');
            $table->date('issuedate');
            $table->date('lastdate');
            $table->date('recievedate');
            $table->boolean('isprint');
            $table->integer('invoiceno');
            $table->integer('classid')->unsigned();
            $table->foreign('classid')->references('C_id')->on('classes');
            $table->integer('sectionid')->unsigned();
            $table->foreign('sectionid')->references('Sec_ID')->on('Sections');
            $table->boolean('freetransport');
            $table->boolean('issuspence');
            $table->string('pcname', 50);
            $table->string('macaddress', 50);
            $table->string('ipaddress', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_generations');
    }
}
