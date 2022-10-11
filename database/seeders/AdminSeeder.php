<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * adding admins.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Nelson Isioma',
            'email' => 'nelsonisioma1@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
        ])->assignRole('Admin');
    }
}
