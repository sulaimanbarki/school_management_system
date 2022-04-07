<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Configurations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('Configurations', function (Blueprint $table) {
            $table->increments('campusid');
            $table->string('CampusName');
            $table->string('CampusPrefix');
            $table->string('CampusEmail');
            $table->string('DefaultBoard');
            $table->string('DefaultReligion');
            $table->string('Phone');
            $table->string('Phone1')->nullable();
            $table->string('DefaultAddress');
            $table->string('DefaultAddress1')->nullable();
            $table->string('BankName')->nullable();
            $table->string('AccountNumber')->nullable();
            $table->date('RegistraionDate')->nullable();
            $table->string('Logo_photo_path', 2048)->nullable();
            $table->string('banklogo', 2048)->nullable();
            $table->timestamps();
            $table->string('SchoolStatus');
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
