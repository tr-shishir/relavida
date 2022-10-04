<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResizeWebpimageToMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('media','resize_image')) {
            Schema::table('media', function (Blueprint $table) {
                $table->string('resize_image')->nullable();
                $table->string('webp_image')->nullable();
            });
        }
    }

    /**
     * Reverse the migratiocategory_treens.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            //
        });
    }
}
