<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('category_name_en');
            $table->string('category_name_ru');
            $table->string('url');
            $table->enum('property', ['basic', 'custom'])->default('custom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tour_categories');
    }
}
