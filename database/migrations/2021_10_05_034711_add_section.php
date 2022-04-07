<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Sections', function (Blueprint $table) {
            $table->increments('Sec_ID');
            $table->string('SectionName');
            $table->tinyInteger('SectionSequence');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('Configurations');

            // $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
