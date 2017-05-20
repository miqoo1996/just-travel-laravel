<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_tours', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('tour_id')->unsigned();
            $table->foreign('tour_id')->references('id')->on('tours');
            $table->integer('hotel_id')->unsigned();
            $table->foreign('hotel_id')->references('id')->on('hotels');
            $table->string('date_from');
            $table->integer('adult');
            $table->integer('child');
            $table->integer('infant');
            $table->string('order_id');
            $table->integer('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_tours');
    }
}
