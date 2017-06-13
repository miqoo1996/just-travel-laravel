<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $current_time = Carbon::now();

        //delete tours table records
        DB::table('pages')->delete();
        //insert some dummy records
        DB::table('pages')->insert([
            [
                'created_at' => $current_time,
                'updated_at' => $current_time,
                'page_name_en' => 'Tours',
                'page_name_ru' => 'Туры',
                'page_url' => '/tours',
                'desc_en' => '',
                'desc_ru' => '',
                'image' => '',
                'visibility' => 'on',
                'footer' => 'on',
                'type' => 1,
            ],
            [
                'created_at' => $current_time,
                'updated_at' => $current_time,
                'page_name_en' => 'Photo Gallery',
                'page_name_ru' => 'Фото Галерея',
                'page_url' => '/galleries',
                'desc_en' => '',
                'desc_ru' => '',
                'image' => '',
                'visibility' => 'on',
                'footer' => 'on',
                'type' => 1,
            ],
            [
                'created_at' => $current_time,
                'updated_at' => $current_time,
                'page_name_en' => 'Portfolio',
                'page_name_ru' => 'Портфолио',
                'page_url' => '/portfolio',
                'desc_en' => '',
                'desc_ru' => '',
                'image' => '',
                'visibility' => 'on',
                'footer' => 'on',
                'type' => 1,
            ],
            [
                'created_at' => $current_time,
                'updated_at' => $current_time,
                'page_name_en' => 'Video Gallery',
                'page_name_ru' => 'Видео Галерея',
                'page_url' => '/video_gallery',
                'desc_en' => '',
                'desc_ru' => '',
                'image' => '',
                'visibility' => 'on',
                'footer' => 'on',
                'type' => 1,
            ],
            [
                'created_at' => $current_time,
                'updated_at' => $current_time,
                'page_name_en' => 'Catalogue',
                'page_name_ru' => 'Каталог',
                'page_url' => '/catalogue',
                'desc_en' => '',
                'desc_ru' => '',
                'image' => '',
                'visibility' => 'on',
                'footer' => 'on',
                'type' => 1,
            ],
            [
                'created_at' => $current_time,
                'updated_at' => $current_time,
                'page_name_en' => 'Contacts',
                'page_name_ru' => 'Контакты',
                'page_url' => '/contacts',
                'desc_en' => '',
                'desc_ru' => '',
                'image' => '',
                'visibility' => 'on',
                'footer' => 'on',
                'type' => 1,
            ]
        ]);
    }
}
