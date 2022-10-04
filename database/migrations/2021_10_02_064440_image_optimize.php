<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ImageOptimize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('image_optimize')) {
            Schema::create('image_optimize', function (Blueprint $table) {
                $table->increments('id');
                $table->string('status')->nullable();
                $table->string('compress')->nullable();
                $table->string('minimum_size')->nullable();
                $table->string('thumbnail_width')->nullable();
                $table->string('thumbnail_height')->nullable();
                $table->string('original_width')->nullable();
                $table->string('original_height')->nullable();
                $table->string('live_edit_compress')->nullable();
                $table->string('live_edit_minimum_size')->nullable();
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
        //<a href="javascript:;" onclick="mw_reload_all_modules()" class="btn btn-primary reload-module-btn icon-left"><i class="mdi mdi-refresh icon-left"></i> Reload modules</a>
    }
}
