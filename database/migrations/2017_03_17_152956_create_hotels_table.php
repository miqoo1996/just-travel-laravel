<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('hotel_url');
            $table->string('regions');
            $table->string('hotel_name_en');
            $table->string('hotel_name_ru');
            $table->text('desc_en');
            $table->text('desc_ru');
            $table->text('short_desc_en');
            $table->text('short_desc_ru');
            $table->text('tags_en');
            $table->text('tags_ru');
            $table->enum('type', ['1_star','2_star', '3_star', '4_star', '5_star', 'motel', 'hostel',]);
            $table->text('images');
            $table->string('main_image');
            $table->enum('visibility', ['on', 'off'])->default('off');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hotels');
    }
}
