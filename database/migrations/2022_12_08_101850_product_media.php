<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('product_media')){
            Schema::create('product_media', function (Blueprint $table) {
                $table->id();
                $table->string('session_id');
                $table->integer('rel_id');
                $table->integer('position');
                $table->string('filename');
                $table->integer('image_id');
                $table->string('resize_image');
                $table->string('webp_image');
                $table->timestamps();
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
