<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsVariantsOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_variants_options', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_variant_id')->unsigned()->index();
            $table->foreign('product_variant_id')->references('id')->on('products_variants_options');
            $table->string('variant_value_name');
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
        Schema::dropIfExists('products_variants_options');
    }
}
