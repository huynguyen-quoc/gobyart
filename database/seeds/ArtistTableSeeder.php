<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Webpatser\Uuid\Uuid as Uuid;
use Illuminate\Support\Facades\Log as Log;

class ArtistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('artist')->truncate();
//        $faker = Faker::create();
//        $types = [ 1, 2, 3, 4, 5];
//        $artists = [];
//
//        foreach(range(1 , 30) as $index) {
//            Log::info('index'.$index);
//            $firstName =  $faker->firstName;
//            $lastName =  $faker->lastName;
//            $fullName =  $firstName.' '.$lastName;
//            $artists[] = [
//                'artist_id' =>  Uuid::generate(5,'artist'.microtime(true).$index, Uuid::NS_DNS),
//                'first_name' => strtolower($firstName),
//                'last_name' => strtolower($lastName),
//                'slug' => str_slug($fullName),
//                'full_name' => $fullName,
//                'description' => $faker->realText(200),
//                'extra_information' => '',
//                'date_of_birth' => new DateTime,
//                'gender' => rand(1,2),
//                'music_category_id' => rand(1,5),
//                'seo_id'=> $index,
//                'created_at' => new DateTime,
//                'updated_at' => new DateTime
//
//            ];
//        }
//
//        DB::table('artist')->insert($artists);
    }
}
