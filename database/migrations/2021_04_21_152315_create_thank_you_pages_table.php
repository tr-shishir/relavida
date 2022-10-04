<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThankYouPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        if (!Schema::hasTable('thank_you_pages')) {
            Schema::create('thank_you_pages', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('template_name');
                $table->bigInteger('product_id');
                $table->bigInteger('is_active');
            });
        }
            // Code to create table
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thank_you_pages');
    }
}
