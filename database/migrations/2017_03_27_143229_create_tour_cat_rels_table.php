<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourCatRelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_cat_rels', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('tour_id')->unsigned()->nullable();
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
            $table->integer('cat_id')->unsigned()->nullable();
            $table->foreign('cat_id')->references('id')->on('tour_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tour_cat_rels');
    }
}
