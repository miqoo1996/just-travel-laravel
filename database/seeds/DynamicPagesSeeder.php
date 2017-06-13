<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DynamicPagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = DB::table('pages')->select('id')->get();

        if ($pages) {
            $data = [];
            foreach ($pages as $page) {
                $data[] = ['page_id' => $page->id];
            }
            //delete tours table records
            DB::table('dynamic_pages')->delete();
            //insert some dummy records
            DB::table('dynamic_pages')->insert($data);
        }
    }
}
