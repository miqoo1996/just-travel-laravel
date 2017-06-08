<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('loc_amount');
            $table->string('expiration');
            $table->string('cardholderName');
            $table->integer('depositAmount');
            $table->string('currency');
            $table->string('approvalCode');
            $table->string('authCode');
            $table->string('ErrorCode');
            $table->string('ErrorMessage');
            $table->string('OrderStatus');
            $table->string('OrderNumber');
            $table->string('Pan');
            $table->integer('Amount');
            $table->string('Ip');
            $table->string('SvfeResponse');
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
        Schema::drop('payments');
    }
}
