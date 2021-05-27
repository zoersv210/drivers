<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriversTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('drivers')->insert([
            [
            'first_name' => 'John1',
            'last_name' => 'Doy1',
            'email' => 'doy1@gmail.com',
            'phone' => '111111111',
            'lon' => '49.233159052614354',
            'lat' => '28.490072225545653',
            ],
            [
            'first_name' => 'John2',
            'last_name' => 'Doy2',
            'email' => 'doy2@gmail.com',
            'phone' => '222222222',
            'lon' => '49.237978767365725',
            'lat' => '28.47942921810201',
            ],
        ]);
    }
}
