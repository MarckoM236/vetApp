<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@app.com',
            'password' => bcrypt('12345678'),
            'identificacion' => 123456789,
            'lastName' => 'Admin',
            'role_id' => 1,
            'status' => 1
        ]);

    }
}
