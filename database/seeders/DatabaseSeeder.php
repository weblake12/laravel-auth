<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        DB::table('users')->insert([
            [
                'name' => 'Lionel AKE',
                'username' => 'weblake12',
                'email' => 'contact@lionel-ake.com',
                'password' => Hash::make('beatrichner')
            ]
        ]);
    }
}
