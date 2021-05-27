<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = DB::table('users')
            ->where('email', 'admin@mail.com')
            ->first();

        $admin = DB::table('users')
            ->where('email', 'admin1@mail.com')
            ->first();

        if (null === $superAdmin) {
            DB::table('users')->insert([
                'first_name' => 'Admin11',
                'last_name' => 'Admin12',
                'email' => 'admin@mail.com',
                'password' => Hash::make('admin1'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if (null === $admin) {
            DB::table('users')->insert([
                'first_name' => 'Admin22',
                'last_name' => 'Admin21',
                'email' => 'admin1@mail.com',
                'password' => Hash::make('admin1'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
