<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsAtCartOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('cart_orders','billing_country')) {
            Schema::table('cart_orders', function (Blueprint $table) {
                $table->string('shipping_name')->nullable()->after('email');
                $table->string('billing_name')->nullable()->after('address2');
                $table->string('billing_country')->nullable()->after('billing_name');
                $table->string('billing_city')->nullable()->after('billing_country');
                $table->string('billing_state')->nullable()->after('billing_city');
                $table->string('billing_zip')->nullable()->after('billing_state');
                $table->string('billing_address')->nullable()->after('billing_zip');
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
