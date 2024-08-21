<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(15)->create();

        User::factory()->count(2)->create([
            'role' => 'office',
            'password' => Hash::make('admin-password'),
        ]);

        User::factory()->count(3)->create([
            'role' => 'management',
            'password' => Hash::make('admin-password'),
        ]);
    }
}
