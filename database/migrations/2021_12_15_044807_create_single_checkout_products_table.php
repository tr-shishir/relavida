<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSingleCheckoutProductsTable extends Migration
{
    /**
     * Run the migrations.
     * 1.27.0
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('single_checkout_products')) {
            Schema::create('single_checkout_products', function (Blueprint $table) {
                $table->id();
                $table->string('module_id');
                $table->integer('product_id');
                $table->timestamps();
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
        Schema::dropIfExists('single_checkout_products');
    }
}
