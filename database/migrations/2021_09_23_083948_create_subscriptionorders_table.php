<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('subscriptionorders')) {
        Schema::create('subscriptionorders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('product_id');
            $table->integer('product_quantity');
            $table->string('subscription_product_price');
            $table->integer('order_id');
            $table->string('plan_id');
            $table->string('agreement_id');
            $table->string('email');
            $table->dateTime('next_billing_date');
            $table->integer('cycle_completed');
            $table->integer('cycle_remaining');
            $table->integer('total_cycle');
            $table->integer('failed_payment_count');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('state');
            $table->string('payment_method');
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
        Schema::dropIfExists('subscriptionorders');
    }
}
