<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Blogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('blogs')) {
            Schema::create('blogs', function (Blueprint $table) {
                $table->id();
                $table->string('content_id', 255)->nullable();
                $table->string('title', 255)->nullable();
                $table->longText('content')->nullable();
                $table->string('link', 255)->nullable();
                $table->string('image', 255)->nullable();
                $table->integer('is_rss')->default(0);
                $table->string('rss_link', 255)->nullable();
                $table->string('rss_image', 255)->nullable();
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
