<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductOrderTable extends Migration 
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_order', function (Blueprint $table) {  //order_product_combination

            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_combination_id');
            $table->unsignedBigInteger('quantity')->defaults(1);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('product_combination_id')->references('id')->on('products_combinations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_order', function(Blueprint $table){
            $table->dropForeign(['order_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['product_combination_id']);
        });

        Schema::dropIfExists('product_order');
    }
}
