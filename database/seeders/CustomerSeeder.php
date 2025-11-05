<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            ['name' => 'Andi Wijaya', 'phone' => '0812-3456-7890'],
            ['name' => 'Siti Nurhaliza', 'phone' => '0822-3456-7890'],
            ['name' => 'Ahmad Fauzi', 'phone' => '0831-2345-6789'],
            ['name' => 'Dewi Lestari', 'phone' => '0844-5678-9012'],
            ['name' => 'Rizky Aditya', 'phone' => '0855-6789-0123'],
            ['name' => 'Maya Sari', 'phone' => '0866-7890-1234'],
            ['name' => 'Eko Prasetyo', 'phone' => '0877-8901-2345'],
            ['name' => 'Indah Permata', 'phone' => '0888-9012-3456'],
            ['name' => 'Fajar Nugroho', 'phone' => '0899-0123-4567'],
            ['name' => 'Ratna Wijaya', 'phone' => '0811-2345-6789'],
            ['name' => 'Budi Santoso', 'phone' => '0813-4567-8901'],
            ['name' => 'Sarah Amanda', 'phone' => '0821-5678-9012'],
            ['name' => 'Reza Pahlevi', 'phone' => '0832-6789-0123'],
            ['name' => 'Lisa Mariani', 'phone' => '0843-7890-1234'],
            ['name' => 'Doni Hermawan', 'phone' => '0854-8901-2345'],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        $this->command->info('✅ ' . count($customers) . ' customers created successfully!');
    }
}