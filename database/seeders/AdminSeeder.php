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
     *
     * @return void
     */
    public function run()
    {
        $data_admin = [
            ['name' => "admin123",'email' => 'admin@gmail.com','password' => Hash::make('admin12345'),'is_admin' => 1]
        ];

        DB::table('users')->insert($data_admin);
    }
}
