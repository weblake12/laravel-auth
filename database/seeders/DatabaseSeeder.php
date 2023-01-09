<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
            [
                'name' => 'Lionel AKE',
                'username' => 'beatrichner',
                'email' => 'contact@lionel-ake.com',
                'password' => Hash::make('password'),
                'created_at' => time(),
            ]
        ]);
    }
}
