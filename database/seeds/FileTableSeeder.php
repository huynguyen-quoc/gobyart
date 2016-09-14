<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Webpatser\Uuid\Uuid as Uuid;
use Illuminate\Support\Facades\Log as Log;

class FileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('file')->truncate();
//        $faker = Faker::create();
//        $files = [];
//
//        foreach(range(1, 30) as $index) {
//            Log::info('index'.$index);
//            $files[] = [
//                'file_id' =>  Uuid::generate(5,'file_id'.microtime(true).$index, Uuid::NS_DNS),
//                'original_name' => strtolower($faker->firstName),
//                'extension' => 'jpg',
//                'slug' =>  str_slug($faker->firstName, '-'),
//                'seo_id' => rand(1,5),
//                'order' =>  DB::raw('(select ifnull(max(g.order), 0) + 1 from `file` as g)'),
//                'created_at' => new DateTime,
//                'updated_at' =>  new DateTime
//            ];
//        }
//
//        DB::table('file')->insert($files);
    }
}
