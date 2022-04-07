<?php

use Doctrine\DBAL\Schema\Sequence;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('billno')->default(0);
            $table->string('itemcode');
            $table->foreign('itemcode')->references('itemcode')->on('items');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->bigInteger('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('saleman_id')->unsigned();
            // transaction_type: 1-purchase, 2-sale, 3-transfer, 4-return
            $table->integer('purchase_price');
            $table->integer('sale_price');
            $table->integer('qty');
            $table->unsignedTinyInteger('transaction_type');
            $table->date('date');
            $table->smallInteger('sequence');
            $table->tinyInteger('isdisplay');
            $table->smallInteger('isdelete')->default(0);
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
        Schema::dropIfExists('transactions');
    }
}
