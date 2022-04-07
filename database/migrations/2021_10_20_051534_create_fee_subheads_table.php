<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeSubheadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feesubheads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subhead', 100);
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->integer('amount');
            $table->string('description');
            $table->integer('sequence');
            $table->boolean('transport_status');
            $table->date('date');
            $table->bigInteger('addedby')->unsigned();
            $table->foreign('addedby')->references('id')->on('admins');
            $table->string('isdefault', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_subheads');
    }
}
