<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductDataAddContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('content','brand')) {
            Schema::table('content', function (Blueprint $table) {
                $table->string('brand', 255)->nullable();
            });
        }
        if (!Schema::hasColumn('content','delivery_days')) {
            Schema::table('content', function (Blueprint $table) {
                $table->string('delivery_days', 255)->nullable();
            });
        }
        if (!Schema::hasColumn('content','item_size')) {
            Schema::table('content', function (Blueprint $table) {
                $table->string('item_size', 255)->nullable();
            });
        }
        if (!Schema::hasColumn('content','item_weight')) {
            Schema::table('content', function (Blueprint $table) {
                $table->string('item_weight', 255)->nullable();
            });
        }
        if (!Schema::hasColumn('content','item_color')) {
            Schema::table('content', function (Blueprint $table) {
                $table->string('item_color', 255)->nullable();
            });
        }
        if (!Schema::hasColumn('content','materials')) {
            Schema::table('content', function (Blueprint $table) {
                $table->string('materials', 255)->nullable();
            });
        }
        if (!Schema::hasColumn('content','production_year')) {
            Schema::table('content', function (Blueprint $table) {
                $table->string('production_year', 255)->nullable();
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
