<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TourCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //delete tours table records
        DB::table('tour_categories')->delete();
        //insert some dummy records
        DB::table('tour_categories')->insert(array(
                array('category_name_en'=>'Daily Tours', 'category_name_ru'=>'Ежедневние Туры', 'property' => 'basic')
            )
        );
    }
}
