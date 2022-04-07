<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('expense_head_id')->unsigned();
            $table->foreign('expense_head_id')->references('id')->on('expense_heads');
            $table->string("expense_desc")->nullable();
            $table->date("expense_date");
            $table->float("expense_amount");
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
        Schema::dropIfExists('expenses');
    }
}
