<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin Salon',
            'email' => 'admin@smartsalon.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Kasir Users
        User::create([
            'name' => 'Kasir Salon',
            'email' => 'kasir@smartsalon.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ]);

        $this->command->info('✅ Users created successfully!');
        $this->command->info('📧 Admin: admin@smartsalon.com / password');
        $this->command->info('📧 Kasir: kasir@smartsalon.com / password');
    }
}