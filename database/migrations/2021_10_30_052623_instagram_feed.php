<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InstagramFeed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('instagram_feed')) {
            Schema::create('instagram_feed', function (Blueprint $table) {
                $table->increments('id');
                $table->string('media_id')->nullable();
                $table->string('instagram_id')->nullable();
                $table->string('insta_img_description')->nullable()->collation('utf8mb4_unicode_ci');;
                $table->string('insta_username')->nullable();
                $table->string('insta_post_date')->nullable();
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
