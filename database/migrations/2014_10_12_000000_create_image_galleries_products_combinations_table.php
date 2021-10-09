<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageGalleriesProductsCombinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_galleries_products_combinations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('image_gallery_id')->unsigned()->index();
            $table->foreign('image_gallery_id')->references('id')->on('image_galleries');
            $table->bigInteger('prod_comb_id')->unsigned()->index();
            $table->foreign('prod_comb_id')->references('id')->on('products_combinations');
            $table->boolean('isFeatured');
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
        Schema::dropIfExists('image_galleries_products_combinations');
    }
}
