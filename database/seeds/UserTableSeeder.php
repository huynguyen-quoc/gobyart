<?php

use Illuminate\Database\Seeder;
use Webpatser\Uuid\Uuid as Uuid;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use \Firebase\JWT\JWT;
use Illuminate\Support\Facades\Log as Log;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('user')->truncate();
        $faker = Faker::create();
        $users = [];

        $users[] = [
            'user_sid' =>  Uuid::generate(5,'user'.microtime(true), Uuid::NS_DNS),
            'name' => strtolower($faker->name),
            'user_name' => 'admin',
            'email' => $faker->email,
            'password' => Hash::make('12345678'),
            'confirmation_code' => '1',
            'created_at' => new DateTime,
            'updated_at' =>  new DateTime
        ];

        DB::table('user')->insert($users);
    }
}
