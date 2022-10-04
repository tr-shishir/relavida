<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Products extends Migration
{
    /**
     * Run the migrations.
     * 1.27.0
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('content_id', 255)->nullable();
                $table->string('title', 255)->nullable();
                $table->string('url', 255)->nullable();
                $table->string('image', 255)->nullable();
                $table->string('price', 255)->nullable();
                $table->string('tax_type', 255)->nullable();
                $table->string('quantity', 255)->nullable();
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
