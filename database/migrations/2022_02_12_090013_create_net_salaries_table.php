<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('net_salaries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('empid')->unsigned();
            $table->foreign('empid')->references('id')->on('admins');
            $table->integer('eobiamount');
            $table->integer('basicpay');
            $table->integer('allowanceamount');
            $table->integer('bonusamount');
            $table->integer('deductionamount');
            $table->integer('grosssalary');
            $table->integer('netsalary');
            $table->integer('leaveamount');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->date('date');
            $table->smallInteger('year');
            $table->smallInteger('month');
            $table->boolean('ispaid');
            $table->smallInteger('addedby');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('net_salaries');
    }
}
