<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReduceToTaxTable extends Migration
{
    /**
     * Run the migrations.
     * 1.27.0
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tax_rates','reduced_charge')) {
            Schema::table('tax_rates', function (Blueprint $table) {
                $table->string('reduced_charge', 255)->nullable();
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
        Schema::table('tax_rates', function (Blueprint $table) {
            //
        });
    }
}
