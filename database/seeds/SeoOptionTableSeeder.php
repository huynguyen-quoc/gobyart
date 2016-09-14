<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Webpatser\Uuid\Uuid as Uuid;
use Illuminate\Support\Facades\Log as Log;

class SeoOptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('seo_option')->truncate();
        $faker = Faker::create();
        $seos = [];

        foreach(range(1, 30) as $index) {
            Log::info('index'.$index);
            $seos[] = [
                'seo_id' =>  Uuid::generate(5,'seo_option'.microtime(true).$index, Uuid::NS_DNS),
                'meta' => strtolower($faker->firstName),
                'keywords' => strtolower($faker->lastName),
                'created_at' => new DateTime,
                'updated_at' =>  new DateTime
            ];
        }

        DB::table('seo_option')->insert($seos);
    }
}
