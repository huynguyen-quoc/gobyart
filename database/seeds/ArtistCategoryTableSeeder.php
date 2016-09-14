<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Webpatser\Uuid\Uuid as Uuid;
use Illuminate\Support\Facades\Log as Log;

class ArtistCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('artist_category')->truncate();
        $faker = Faker::create();
        $category = [];

        foreach(range(1,30) as $index) {
          $category[] = [
            'category_id' =>   Uuid::generate(5,'artist'.microtime(true), Uuid::NS_DNS),
            'name' => $faker->name,
            'slug'=> str_slug( $faker->name),
            'seo_id' => $index,
            'group_id' => $index,
            'order' =>  DB::raw('(select ifnull(max(ac.category_id), 0) + 1 from `artist_category` as ac)'),

          ];
        }

        DB::table('artist_category')->insert($category);
    }
}
