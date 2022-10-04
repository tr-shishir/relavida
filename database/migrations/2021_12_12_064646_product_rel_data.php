<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductRelData extends Migration
{
    /**
     * Run the migrations.
     * 1.27.0
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product_details')) {
            Schema::create('product_details', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('rel_id');
                $table->string('suplier', 255)->nullable();
                $table->string('tax_rate', 255)->nullable();
                $table->string('tax_type', 255)->nullable();
                $table->string('download_limit', 255)->nullable();
                $table->integer('digital_opt')->nullable()->default(0);
                $table->string('d_P_download_link', 255)->nullable();
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
        //
    }
}
