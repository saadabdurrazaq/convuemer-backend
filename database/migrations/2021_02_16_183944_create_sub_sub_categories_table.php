<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubSubCategoriesTable extends Migration
{
    /**
     * Run the migrations. 
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned()->index();
            $table->bigInteger('subcategory_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('subcategory_id')->references('id')->on('sub_categories');
            $table->string('subsubcategory_name');
            $table->string('subsubcategory_slug');  
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
        Schema::dropIfExists('sub_sub_categories');
    }
}
