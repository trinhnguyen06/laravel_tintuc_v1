<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        //$this->call(TheLoaiTableSeeder::class);
        //$this->call(LoaiTinTableSeeder::class);
        //$this->call(TinTucTableSeeder::class);
        $this->call(CommentTableSeeder::class);
    }
}
