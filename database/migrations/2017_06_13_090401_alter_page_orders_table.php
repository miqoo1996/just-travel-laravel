<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPageOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_orders', function (Blueprint $table) {
            $table->tinyInteger('right_menu')->default(0);
            $table->tinyInteger('footer')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('page_orders', function (Blueprint $table) {
            $table->dropColumn(['right_menu', 'footer']);
        });
    }
}
