<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductUpsellingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product_upselling_item')) {
            Schema::create('product_upselling_item', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('product_id');
                $table->bigInteger('item_id');
                $table->bigInteger('selected');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_upselling_items');
    }
}
