<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@regalest.com'],
            [
                'name' => 'Regalest Super Admin',
                'password' => Hash::make('password123'),
                'phone' => '+963999999999',
                'address' => 'Damascus, Syria',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $admin->syncRoles(['super_admin']);
    }
}
