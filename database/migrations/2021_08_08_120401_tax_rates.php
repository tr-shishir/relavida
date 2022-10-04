<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TaxRates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('tax_rates')) {
            Schema::create('tax_rates', function (Blueprint $table) {
                $table->increments('id');
                $table->string('country')->nullable();
                $table->string('country_de')->nullable();
                $table->string('country_code')->nullable();
                $table->string('charge')->nullable();
                $table->string('created_at')->nullable();
                $table->string('updated_at')->nullable();
                $table->string('lang_kod')->nullable();
                $table->string('alpha_three')->nullable();
                $table->string('is_default')->nullable();
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
