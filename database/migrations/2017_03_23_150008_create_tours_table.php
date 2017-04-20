<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('tour_url');
            $table->string('tour_category');
            $table->string('tour_name_en')->nullable();
            $table->string('tour_name_ru')->nullable();
            $table->text('desc_en')->nullable();
            $table->text('desc_ru')->nullable();
            $table->text('short_desc_en')->nullable();
            $table->text('short_desc_ru')->nullable();
            $table->text('tags_en')->nullable();
            $table->text('tags_ru')->nullable();
            $table->float('basic_price_adult')->nullable();
            $table->float('basic_price_child')->nullable();
            $table->float('basic_price_infant')->nullable();
            $table->string('basic_frequency')->nullable();
            $table->string('specific_days')->nullable();
            $table->string('custom_day_prp')->nullable();
            $table->string('custom_dates')->nullable();
            $table->string('tour_images')->nullable();
            $table->string('main_image')->nullable();
            $table->string('hot_image')->nullable();
            $table->enum('visibility', ['on', 'off'])->default('off');
            $table->enum('hot', ['on', 'off'])->default('off');
            $table->enum('type', ['regular', 'custom'])->default('regular');
            $table->integer('tour_price')->nullable();
            $table->string('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tours');
    }
}
