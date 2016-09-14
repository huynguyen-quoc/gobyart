<?php

use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid as Uuid;

class MusicCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('music_category')->truncate();
        $categories = [];
        $types = [
            'Dance - Remix',
            'Nhạc trữ tình - Cách mạng',
            'Dân ca',
            'Thiếu nhi',
            'Rock Việt',
            'Hiphop',
            'Nhóm nhạc',
            'Ban nhạc',
            'Sexy dance',
            'Belly dance',
            'Thiếu nhi',
            'Hiphop',
            'Dân gian',
            'Global (Hàn Quốc, Nhật, Nga)',
            'Nam',
            'Nữ',
            'PG',
            'PB',
            'Người mẫu',
            'Lân sư rồng',
            'Xiếc - Ảo thuật'
        ];
        $typeId = [
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            3,
            3,
            3,
            3,
            3,
            3,
            4,
            4,
            2,
            2,
            2,
            5,
            5
        ];

        foreach($types as $index=>$data) {
            Log::info('index'.$index);
            $categories[] = [
                'category_id' =>  Uuid::generate(5,'music_category_id'.microtime(true).$index, Uuid::NS_DNS),
                'name' => $data,
                'slug' => str_slug($data, '-').'-'.$index,
                'artist_type_id' => $typeId[$index],
                'order' =>  DB::raw('(select ifnull(max(at.order), 0) + 1 from `music_category` as at)'),
            ];
        }

        DB::table('music_category')->insert($categories);
    }
}
