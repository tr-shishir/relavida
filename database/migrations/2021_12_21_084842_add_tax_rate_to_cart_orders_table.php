<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxRateToCartOrdersTable extends Migration
{
    /**
     * Run the migrations.
     * 1.27.0
     * @return void
     */
    public function up()
    {
        Schema::table('cart_orders', function (Blueprint $table) {
            if(!Schema::hasColumn('cart_orders','tax_rate')) {
                $table->string('tax_rate', 255)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_orders', function (Blueprint $table) {
            //
        });
    }
}
