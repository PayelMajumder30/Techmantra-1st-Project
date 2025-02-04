<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('admin')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => 9423587912,
            'password' => bcrypt('admin#321'),  // Make sure to hash passwords
            'is_admin' => 1,
            'created_at' => now(),
            'role'  => 'admin',
            'is_active' => 1
            
        ]);
    }
}
