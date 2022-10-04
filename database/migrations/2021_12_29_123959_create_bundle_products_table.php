<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBundleProductsTable extends Migration
{
    /**
     * Run the migrations.
     * 1.27.0
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('bundle_products')) {
            Schema::create('bundle_products', function (Blueprint $table) {
                $table->id();
                $table->integer('product_id')->nullable();
                $table->integer('product_qty')->nullable();
                $table->integer('bundle_id')->nullable();
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
        Schema::dropIfExists('bundle_products');
    }
}
