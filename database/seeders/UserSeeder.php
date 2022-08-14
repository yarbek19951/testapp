<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('users')->insert([
//            'name' => "yarbek",
//            'email' => 'yarbek19951@gmail.com',
//            'password' => Hash::make('password'),
//        ]);
        User::factory()
            ->count(50)
            ->create();

    }
}
