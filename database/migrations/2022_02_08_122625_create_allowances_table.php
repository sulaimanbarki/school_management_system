<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allowances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('amount');
            $table->string('allowancetype', 10);
            $table->string('description', 255)->nullable();
            $table->integer('scaleid')->unsigned();
            $table->foreign('scaleid')->references('id')->on('scales');
            $table->integer('sessionid')->unsigned();
            $table->foreign('sessionid')->references('id')->on('academicsessions');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
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
        Schema::dropIfExists('allowances');
    }
}
