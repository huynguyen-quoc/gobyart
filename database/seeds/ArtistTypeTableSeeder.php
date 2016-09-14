<?php

use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid as Uuid;
use Illuminate\Support\Facades\Log as Log;

class ArtistTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('artist_type')->truncate();
        $artistTypes = [];
        $types = [
            'Ca Sĩ',
            'PG PB | Người Mẫu',
            'Nhóm Nhảy',
            'MC',
            'Nghệ Sĩ Khác'
        ];

        foreach($types as $index=>$data) {
            Log::info('index'.$index);
            $artistTypes[] = [
                'type_id' =>  Uuid::generate(5,'artist_type'.microtime(true).$index, Uuid::NS_DNS),
                'name' => $data,
                'slug' => str_slug($data, '-'),
                'order' =>  DB::raw('(select ifnull(max(at.order), 0) + 1 from `artist_type` as at)'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ];
        }

        DB::table('artist_type')->insert($artistTypes);
    }
}
