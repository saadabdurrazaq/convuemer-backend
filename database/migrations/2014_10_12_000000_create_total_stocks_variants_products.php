<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTotalStocksVariantsProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('total_stocks_variants_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_combination_id')->unsigned()->index();
            $table->foreign('product_combination_id')->references('id')->on('products_combinations');
            $table->integer('total_stock');
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
        Schema::dropIfExists('total_stocks_variants_products');
    }
}
