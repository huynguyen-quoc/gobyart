<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

      //  $this->call(SeoOptionTableSeeder::class);
        $this->call(GroupTableSeeder::class);
        $this->call(ArtistTypeTableSeeder::class);
        $this->call(SeoOptionTableSeeder::class);
        $this->call(ArtistTableSeeder::class);
        $this->call(SiteOptionTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(FileTableSeeder::class);
        $this->call(FileGroupTableSeeder::class);
        $this->call(TeamTableSeeder::class);
        $this->call(MusicCategoryTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        Model::reguard();
    }
}
