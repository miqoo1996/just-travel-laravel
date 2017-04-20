<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(TourCategoriesSeeder::class);
         $this->call(CurrencySeeder::class);
    }
}
