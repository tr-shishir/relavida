<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content', function (Blueprint $table) {

            if (!Schema::hasColumn('content', 'is_rss')) {
                $table->integer('is_rss')->nullable()->default(0);
            }
            if (!Schema::hasColumn('content', 'rss_link')) {
                $table->string('rss_link')->nullable();
            }
            if (!Schema::hasColumn('content', 'rss_image')) {
                $table->string('rss_image')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content', function (Blueprint $table) {
            //
        });
    }
}
