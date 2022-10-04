<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderWithUpsellingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('order_with_upselling')) {
            Schema::create('order_with_upselling', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('product_id');
                $table->bigInteger('service_id');
                $table->bigInteger('user_id');
                $table->bigInteger('order_id');
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
        Schema::dropIfExists('order_with_upsellings');
    }
}
