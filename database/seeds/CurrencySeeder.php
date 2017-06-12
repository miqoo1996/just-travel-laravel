<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //delete tours table records
        DB::table('currencies')->delete();
        //insert some dummy records
        DB::table('currencies')->insert(array(
                array('amd'=>1, 'rur'=>7.9, 'eur' => 502, 'usd'=> 498)
            )
        );
    }
}
