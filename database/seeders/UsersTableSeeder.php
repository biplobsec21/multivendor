<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            // Admin user
            [
                'name' => 'Admin user',
                'username'=>'admin',
                'email'=>'admin@gmail.com',
                'password'=>Hash::make('123'),
                'role'=>'admin',
                'status'=>'active',
            ],
            // Vendor user
            [
                'name' => 'Vendor user',
                'username'=>'vendor',
                'email'=>'vendor@gmail.com',
                'password'=>Hash::make('123'),
                'role'=>'vendor',
                'status'=>'active',
            ],
             // Vendor user
             [
                'name' => 'Public user',
                'username'=>'public',
                'email'=>'public@gmail.com',
                'password'=>Hash::make('123'),
                'role'=>'user',
                'status'=>'active',
            ]
        ]);
    }
}
