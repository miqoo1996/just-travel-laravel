<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderColumnToDownloadPDFs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('download_p_d_fs', function (Blueprint $table) {
            $table->tinyInteger('order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('download_p_d_fs', function (Blueprint $table) {
            $table->dropColumn(['order']);
        });
    }
}
