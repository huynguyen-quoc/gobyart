<?php

use Illuminate\Database\Seeder;

class FileGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('file_group')->truncate();
//        $groups = [];
//
//        foreach(range(1, 30) as $index) {
//            Log::info('index'.$index);
//            $groups[] = [
//                'file_id' => $index,
//                'group_id' => 5,
//                'created_at' => new DateTime,
//                'updated_at' =>  new DateTime
//            ];
//        }
//
//        DB::table('file_group')->insert($groups);
    }
}
