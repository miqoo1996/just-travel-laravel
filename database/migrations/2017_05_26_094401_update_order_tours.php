<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderTours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_tours', function (Blueprint $table) {
            $table->enum('status', ['pending','payed', 'declined'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_tours', function (Blueprint $table) {
            $table->dropColumn(['status']);
        });
    }
}
