<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxRateToCartTable extends Migration
{
    /**
     * Run the migrations.
     * 1.27.0
     * @return void
     */
    public function up()
    {
        Schema::table('cart', function (Blueprint $table) {
            if(!Schema::hasColumn('cart','tax_rate')) {
                $table->string('tax_rate', 255)->nullable();
            }
            if(!Schema::hasColumn('cart','download_limit')) {
                $table->string('download_limit', 255)->nullable();
            }
            if(!Schema::hasColumn('cart','digital_product')) {
                $table->string('digital_product', 255)->nullable();
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
        Schema::table('cart', function (Blueprint $table) {
            //
        });
    }
}
