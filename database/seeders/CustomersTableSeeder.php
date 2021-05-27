<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            [
                'first_name' => 'Serg1',
                'last_name' => 'Zoer1',
                'email' => 'zoer1@gmail.com',
                'phone' => '333333333',
                'address' => 'Vinnitsia1',
                'lon' => '49.23988085871905',
                'lat' => '28.399400637767382',
            ],
            [
                'first_name' => 'Serg2',
                'last_name' => 'Zoer2',
                'email' => 'zoer2@gmail.com',
                'phone' => '444444444',
                'address' => 'Vinnitsia2',
                'lon' => '49.25989587034205',
                'lat' => '28.574962927944416',
            ],
            [
                'first_name' => 'Serg3',
                'last_name' => 'Zoer3',
                'email' => 'zoer3@gmail.com',
                'phone' => '555555555',
                'address' => 'Vinnitsia3',
                'lon' => '49.220378928343166',
                'lat' => '28.574529616233875',
            ],
            [
                'first_name' => 'Serg4',
                'last_name' => 'Zoer4',
                'email' => 'zoer4@gmail.com',
                'phone' => '666666666',
                'address' => 'Vinnitsia4',
                'lon' => '49.2865979348884',
                'lat' => '28.47582433173967',
            ]
        ]);
    }
}
