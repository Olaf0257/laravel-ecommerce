<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchableProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('searchable_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('objectID');
            $table->string('hierarchy_radio_lvl0')->nullable();
            $table->string('hierarchy_radio_lvl1')->nullable();
            $table->string('hierarchy_radio_lvl2')->nullable();
            $table->string('hierarchy_radio_lvl3')->nullable();
            $table->string('hierarchy_radio_lvl4')->nullable();
            $table->string('hierarchy_radio_lvl5')->nullable();
            $table->string('hierarchy_lvl0');
            $table->string('hierarchy_lvl1')->nullable();
            $table->string('hierarchy_lvl2');
            $table->string('hierarchy_lvl3');
            $table->string('hierarchy_lvl4')->nullable();
            $table->string('hierarchy_lvl5')->nullable();
            $table->string('hierarchy_lvl6')->nullable();
            $table->text('content');
            $table->string('url');
            $table->string('anchor')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('searchable_products');
    }
}
