<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('page_url');
            $table->string('page_name_en');
            $table->string('page_name_ru');
            $table->string('desc_en');
            $table->string('desc_ru');
            $table->string('image');
            $table->enum('visibility', ['off', 'on'])->default('off');
            $table->enum('footer', ['off', 'on'])->default('off');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pages');
    }
}
