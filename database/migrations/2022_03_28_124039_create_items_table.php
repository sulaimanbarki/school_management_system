<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('itemcode');
            $table->string('item_name');
            $table->bigInteger('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->integer('campusid')->unsigned();
            $table->foreign('campusid')->references('campusid')->on('configurations');
            $table->bigInteger('main_category_id')->unsigned();
            $table->foreign('main_category_id')->references('id')->on('main_categories');
            $table->bigInteger('sub_category_id')->unsigned();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
            $table->string('unit', 20);
            $table->integer('purchase_price');
            $table->integer('sale_price');
            $table->date('added_date');
            $table->integer('qty')->default(0);
            $table->tinyInteger('isdisplay');
            $table->smallInteger('sequence');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

            $table->unique(['itemcode', 'item_name', 'company_id', 'campusid', 'main_category_id', 'sub_category_id'], 'item_duplicate_control');
            $table->unique(['itemcode', 'campusid'], 'item_duplicate_control1');
            $table->unique(['item_name', 'campusid'], 'item_duplicate_control12');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
