<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id');
            $table->enum('member_prp',['adult', 'child', 'infant']);
            $table->string('member_name');
            $table->string('member_surname');
            $table->string('member_dob');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_members');
    }
}
