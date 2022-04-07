<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeheadsRecordSessionWisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeheads_record_session_wise', function (Blueprint $table) {
            $table->id();
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->integer('classid')->unsigned();
            $table->foreign('classid')->references('C_id')->on('classes');
            $table->integer('sessionid')->unsigned();
            $table->foreign('sessionid')->references('id')->on('academicsessions');
            $table->integer('subheadid')->unsigned();
            $table->foreign('subheadid')->references('id')->on('feesubheads');
            $table->integer('amount');
            // $table->foreign('amount')->references('id')->on('classwisefeecriterias');
            $table->boolean('isdisplay');
            $table->integer('sequence');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feeheads_record_session_wises');
    }
}
