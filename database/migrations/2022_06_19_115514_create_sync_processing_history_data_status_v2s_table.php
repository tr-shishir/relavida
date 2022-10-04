<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyncProcessingHistoryDataStatusV2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('sync_processing_data_status_v2')){
            Schema::create('sync_processing_data_status_v2', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('processing_id')->nullable();
                $table->bigInteger('content_id')->nullable();
                $table->bigInteger('drm_ref_id')->nullable();
                $table->text('msg')->nullable();
                $table->boolean('is_success')->default(0);
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
        Schema::dropIfExists('sync_processing_data_status_v2');
    }
}
