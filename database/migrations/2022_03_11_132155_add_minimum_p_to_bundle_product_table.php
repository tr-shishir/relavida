<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinimumPToBundleProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bundle_products', function (Blueprint $table) {
            if (!Schema::hasColumn('bundle_products','minimum_p')) {
                $table->integer('minimum_p')->default(0);
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
        Schema::table('bundle_products', function (Blueprint $table) {
            //
        });
    }
}
