<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_members', function (Blueprint $table) {
            $table->integer('order_tour_id')->unsigned();
            $table->foreign('order_tour_id')->references('id')->on('order_tours')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_members', function (Blueprint $table) {
            $table->dropColumn(['order_tour_id']);
        });
    }
}
