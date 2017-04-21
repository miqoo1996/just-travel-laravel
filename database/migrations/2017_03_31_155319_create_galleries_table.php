<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('gallery_name_en');
            $table->string('gallery_name_ru');
            $table->text('gallery_desc_en');
            $table->text('gallery_desc_ru');
            $table->string('gallery_url');
            $table->string('main_image')->nullable();
            $table->enum('portfolio', array('on', 'off'))->default('off');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('galleries');
    }
}
