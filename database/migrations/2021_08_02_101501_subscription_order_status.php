<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubscriptionOrderStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('subscription_order_status')) {
            Schema::create('subscription_order_status', function (Blueprint $table) {
                $table->id();
                $table->string('product_id', 10);
                $table->string('subscription_id', 10);
                $table->string('cycles', 10);
                $table->string('order_price', 15);
                $table->string('order_id', 10)->nullable();
                $table->string('order_status', 30);
                $table->string('user_id', 10);
                $table->string('session_id', 255);
                $table->string('order_count', 5)->nullable();
                $table->string('order_type', 10);
                $table->string('old_order_id', 5)->nullable();
                $table->string('tax_amount', 10);
                $table->string('agreement_id')->nullable();
                $table->string('sub_order_id')->nullable();
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
        Schema::dropIfExists('subscription_order_status');
    }
}
