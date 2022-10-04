<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColToContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content', function (Blueprint $table) {
            if (!Schema::hasColumn('content','gender')) {
                Schema::table('content', function (Blueprint $table) {
                    $table->string('gender', 255)->nullable();
                });
            }
            if (!Schema::hasColumn('content','note')) {
                Schema::table('content', function (Blueprint $table) {
                    $table->string('note', 255)->nullable();
                });
            }
            if (!Schema::hasColumn('content','status')) {
                Schema::table('content', function (Blueprint $table) {
                    $table->string('status', 255)->nullable();
                });
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
