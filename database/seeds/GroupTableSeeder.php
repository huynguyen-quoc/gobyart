<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Webpatser\Uuid\Uuid as Uuid;
use Illuminate\Support\Facades\Log as Log;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('group')->truncate();
        $groups = [];
        $groupType = [
          [
            'key' => 'ARTIST_TYPE',
            'value' => 'HOT_ARTIST'
          ],
          [  'key' => 'SITE_TYPE',
             'value' =>  'TEAM_TYPE'
          ],
          [  'key' => 'FILE_TYPE',
             'value' =>  'AVATAR_TYPE'
          ],
          [
            'key' => 'FILE_TYPE',
            'value' =>  'PARTNER_TYPE'
          ],
          [
            'key' => 'FILE_TYPE',
            'value' =>  'GALLERY_TYPE'
          ]
        ];

        foreach($groupType as $index=>$data) {
            Log::info('data',$data);
            Log::info('index'.$index);
            $groups[] = [
                'group_id' => Uuid::generate(5, 'group'.microtime(true).$index, Uuid::NS_DNS),
                'name' =>$data['key'],
                'type' => $data['value'],
                'order' =>  DB::raw('(select ifnull(max(g.order), 0) + 1 from `group` as g)'),
                'created_at'=> new DateTime,
                'updated_at'=> new DateTime,
            ];
        }

        DB::table('group')->insert($groups);

    }
}
