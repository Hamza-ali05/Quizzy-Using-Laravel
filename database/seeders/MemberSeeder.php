<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        Member::insert([
            [
                'name' => 'Admin One',
                'email' => 'admin1@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin Two',
                'email' => 'admin2@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Student One',
                'email' => 'student1@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Student Two',
                'email' => 'student2@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'student',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
