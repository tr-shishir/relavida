<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeleteFromColumnAtProductSyncHistoryV2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('product_sync_history_v2')){
            Schema::table('product_sync_history_v2', function (Blueprint $table) {
                if (!Schema::hasColumn('product_sync_history_v2','delete_from')) {
                    $table->string('delete_from')->nullable()->after('data_type');
                }
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
        
    }
}
