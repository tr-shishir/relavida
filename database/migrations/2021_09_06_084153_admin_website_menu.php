<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdminWebsiteMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('admin_website_menu')) {
            Schema::create('admin_website_menu', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('shortcut')->nullable();
                $table->integer('position')->nullable();
                $table->string('name', 100)->nullable();
                $table->string('sub_name', 100)->nullable();
                $table->string('link', 100)->nullable();
                $table->string('mw_link', 100)->nullable();
                $table->string('dt_link', 100)->nullable();
                $table->string('dt_temp_link', 100)->nullable();
                $table->string('icon', 100)->nullable();
                $table->string('img', 100)->nullable();
                $table->string('active_name', 100)->nullable();
                $table->string('module_name', 100)->nullable();
                $table->string('data_link', 100)->nullable();
                $table->string('data_title', 100)->nullable();
                $table->string('onclick', 100)->nullable();
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
