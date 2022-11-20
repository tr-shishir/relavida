<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->text("url");
            $table->text("title");
            $table->string("vk_price")->nullable();
            $table->string("quantity")->nullable();
            $table->integer("parent")->nullable();
            $table->text("description");
            $table->integer("position")->nullable();
            $table->string("content_type")->default("product");
            $table->longText("content_body");
            $table->integer("is_active")->default("1");
            $table->integer("is_deleted")->default("0");
            $table->integer("require_login")->default("0");
            $table->string("status")->nullable();
            $table->text("content_meta_title");
            $table->text("content_meta_keywords");
            $table->string("session_id")->nullable();
            $table->dateTime("expires_at")->nullable();
            $table->integer("created_by")->nullable();
            $table->integer("edited_by")->nullable();
            $table->dateTime("posted_at")->nullable();
            $table->string("ean")->nullable();
            $table->integer("drm_ref_id")->nullable();
            $table->string("brand")->nullable();
            $table->string("delivery_days")->nullable();
            $table->string("item_size")->nullable();
            $table->string("item_weight")->nullable();
            $table->string("item_color")->nullable();
            $table->string("materials")->nullable();
            $table->string("production_year")->nullable();
            $table->string("gender")->nullable();
            $table->string("note")->nullable();
            $table->string("ek_price")->nullable();
            $table->string("item_unit")->nullable();
            $table->string("suplier")->nullable();
            $table->string("tax_rate")->nullable();
            $table->string("tax_type")->nullable();
            $table->string("digital_opt")->nullable();
            $table->string("d_P_download_link")->nullable();
            $table->string("download_limit")->nullable();
            $table->longText("offer_options");
            $table->string("sku")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
