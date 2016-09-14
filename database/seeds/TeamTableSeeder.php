<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Webpatser\Uuid\Uuid as Uuid;
use Illuminate\Support\Facades\Log as Log;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('team')->truncate();
//        $faker = Faker::create();
//        $teams = [];
//
//        foreach(range(1, 30) as $index) {
//            Log::info('index'.$index);
//            $teams[] = [
//                'team_id' =>  Uuid::generate(5,'team'.microtime(true).$index, Uuid::NS_DNS),
//                'name' => strtolower($faker->firstName).' '.strtolower($faker->lastName),
//                'slug' =>  str_slug($faker->firstName, '-'),
//                'career' =>  'CEO',
//                'order' =>  DB::raw('(select ifnull(max(t.order), 0) + 1 from `team` as t)'),
//                'created_at' => new DateTime,
//                'updated_at' =>  new DateTime
//            ];
//        }
//
//        DB::table('team')->insert($teams);
    }
}
