<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateScalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description', 255)->nullable();
            $table->integer('basicpay');
            $table->integer('yearlyincrement');
            $table->integer('salarylimit');
            $table->integer('leaveamount');
            $table->boolean('leavestatus');
            $table->integer('eobiamount');
            $table->integer('academicsession')->unsigned();
            $table->foreign('academicsession')->references('id')->on('academicsessions');
            $table->boolean('isactive');
            $table->integer('sequence');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            // $table->timestamps();
            // $table->timestamp('created_at')->useCurrent();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scales');
    }
}
