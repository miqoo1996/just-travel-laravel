<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLeadDataToOrderTours extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_tours', function (Blueprint $table) {
            $table->string('lead_name');
            $table->string('lead_surname');
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
            $table->dropColumn(['lead_name', 'lead_surname']);
        });
    }
}
