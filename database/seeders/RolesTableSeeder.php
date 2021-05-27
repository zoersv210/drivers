<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = DB::table('roles')
            ->where('name', 'admin')
            ->first();

        $superAdmin = DB::table('roles')
            ->where('name', 'super_admin')
            ->first();

        if (null === $admin ) {
            DB::table('roles')->insert([
                'name' => 'super_admin',
                'type' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if (null === $superAdmin ) {
            DB::table('roles')->insert([
                'name' => 'admin',
                'type' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
