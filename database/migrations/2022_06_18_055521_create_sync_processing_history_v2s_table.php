<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyncProcessingHistoryV2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('sync_processing_history_v2')){
            Schema::create('sync_processing_history_v2', function (Blueprint $table) {
                $table->id();
                $table->longText('source');
                $table->string('sync_id');
                $table->bigInteger('count');
                $table->bigInteger('success_count');
                $table->bigInteger('error_count');
                $table->enum('sync_status',['processing', 'success', 'failed']);
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
        Schema::dropIfExists('sync_processing_history_v2');
    }
}
