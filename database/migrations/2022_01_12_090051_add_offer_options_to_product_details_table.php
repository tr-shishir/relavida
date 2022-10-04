<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOfferOptionsToProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     * 1.27.0
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('product_details','offer_options')) {
            Schema::table('product_details', function (Blueprint $table) {
                $table->longText('offer_options')->nullable();
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
        Schema::table('product_details', function (Blueprint $table) {
            //
        });
    }
}
