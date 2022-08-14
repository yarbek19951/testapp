<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $colors = [
            ["code"=>"#12341231"],
            ["code"=>"#eq312231"]
        ];
        $types = [
            ["code"=>"XXX-L"],
            ["code"=>"XXX-M"]
        ];
        DB::table('types')->insert(
            $types
        );
        DB::table('colors')->insert(
            $colors
        );
    }
}
