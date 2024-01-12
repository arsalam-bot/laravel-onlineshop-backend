<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory(9)->create();
        \App\Models\User::factory()->create([
            'name' => 'Alam',
            'email' => 'launualam@gmail.com',
            'password' => Hash::make('123456789'),
            'phone' => '085156419292',
            'roles' => 'Admin'
        ]);
    }
}
