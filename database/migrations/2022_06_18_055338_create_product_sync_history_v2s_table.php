<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSyncHistoryV2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('product_sync_history_v2')){
            Schema::create('product_sync_history_v2', function (Blueprint $table) {
                $table->id();
                $table->longText('data');
                $table->enum('type', ['url', 'ids', 'json']);
                $table->string('count');
                $table->enum('action', ['CREATE', 'UPDATE', 'DELETE', 'RESTART', 'REPAIR']);
                $table->string('sync_id');
                $table->enum('status', ['pending', 'processing', 'failed', 'delete', 'success']);
                $table->string('drm_status');
                $table->string('old_sync_id');
                $table->enum('data_type', ['products', 'categories']);
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
        Schema::dropIfExists('product_sync_history_v2');
    }
}
