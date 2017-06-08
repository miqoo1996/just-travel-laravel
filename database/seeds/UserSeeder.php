<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        //insert some dummy records
        DB::table('users')->insert(array(
                array(
                    'first_name'=>'Just',
                    'last_name'=> 'Travel',
                    'email' => 'admin@jt.com',
                    'password' => bcrypt('123456')
                )
            )
        );
    }
}
