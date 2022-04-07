<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_status', function (Blueprint $table) {
            $table->id();
            $table->integer('sessionid')->unsigned();
            $table->foreign('sessionid')->references('id')->on('academicsessions');
            $table->string('studentid', 20);
            $table->foreign('studentid')->references('studentid')->on('studentinfo');
            $table->integer('classid')->unsigned();
            $table->foreign('classid')->references('C_id')->on('classes');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->string('type', 50);
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
        Schema::dropIfExists('promotion__statuses');
    }
}
