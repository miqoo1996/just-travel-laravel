<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDownloadPDFsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('download_p_d_fs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('pdf_name_en');
            $table->string('pdf_file_en');
            $table->string('pdf_name_ru');
            $table->string('pdf_file_ru');
            $table->string('pdf_thumbnail_en');
            $table->string('pdf_thumbnail_ru');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('download_p_d_fs');
    }
}
