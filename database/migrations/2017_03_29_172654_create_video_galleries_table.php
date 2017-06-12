<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('video_url_en');
            $table->string('video_url_ru');
            $table->string('embed_en');
            $table->string('embed_ru');
            $table->string('video_title_en');
            $table->string('video_title_ru');
            $table->string('video_thumbnail_en');
            $table->string('video_thumbnail_ru');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('video_galleries');
    }
}
