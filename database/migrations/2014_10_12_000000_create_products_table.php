<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('brand_id')->unsigned()->index();
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->bigInteger('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->bigInteger('subcategory_id')->unsigned()->index();
            $table->foreign('subcategory_id')->references('id')->on('sub_categories');
            $table->bigInteger('subsubcategory_id')->unsigned()->index();
            $table->foreign('subsubcategory_id')->references('id')->on('sub_sub_categories');
            $table->string('product_code');
            $table->string('product_name');
            $table->string('product_stock');
            $table->string('product_tags');
            $table->string('selling_price');
            $table->string('discount_price')->nullable();
            $table->string('short_desc');
            $table->string('long_desc');
            $table->enum('product_cond', ['New', 'Second'])->nullable();
            $table->integer('min_order');
            $table->integer('product_weight');
            $table->integer('product_length');
            $table->integer('product_Width');
            $table->integer('product_Height');
            $table->integer('hot_deals')->nullable();
            $table->integer('featured')->nullable();
            $table->integer('special_offer')->nullable();
            $table->integer('special_deals')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('products');
    }
}
