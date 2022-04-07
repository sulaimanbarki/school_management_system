<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSchooleavingcirtificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schooleavingcirtificates', function (Blueprint $table) {
            $table->id();
            $table->string('studentid', 20);
            $table->foreign('studentid')->references('studentid')->on('studentinfo');
            $table->integer('slcno');
            $table->string("type", 100);
            // $table->integer('admissioninclass')->unsigned();
            // $table->foreign('admissioninclass')->references('C_id')->on('classes');
            $table->integer('admissioninclass')->unsigned();
            // $table->foreign('admissioninclass')->references('admissioninclass')->on('studentregistrations');
            $table->integer('classtimeofleaving')->unsigned();
            // $table->foreign('classtimeofleaving')->references('admissioninclass')->on('studentinfo');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->string("conduct", 255);
            $table->string("remarks", 255);
            $table->string("totalattendence", 10);
            $table->string("parentsdays", 10);
            $table->string("religion", 100);
            $table->date('leavingdate');
            $table->string("reasonforleaving", 255);
            // $table->string("reasonforleaving", 255);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schooleavingcirtificates');
    }
}
