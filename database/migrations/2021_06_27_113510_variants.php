<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Variants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('variants')) {
            Schema::create('variants', function (Blueprint $table) {
                $table->increments('id');
                $table->bigInteger('rel_id')->nullable();
                $table->string('title')->nullable();
                $table->string('price')->nullable();
                $table->string('uvp')->nullable();
                $table->string('ean')->nullable();
                $table->string('sku')->nullable();
                $table->string('color')->nullable();
                $table->string('size')->nullable();
                $table->string('materials')->nullable();
                $table->string('drm_ref_id')->nullable();
                $table->longText('description')->nullable();
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
