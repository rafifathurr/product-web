<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'phone' => '081364243280',
            'role' => 1
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('user'),
            'phone' => '089988877733',
            'role' => 0
        ]);
    }
}
