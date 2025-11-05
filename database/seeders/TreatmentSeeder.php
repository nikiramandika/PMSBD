<?php

namespace Database\Seeders;

use App\Models\Treatment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TreatmentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $treatments = [
            // Basic Hair Services
            ['name' => 'Potong Rambut Pria', 'price' => 35000, 'duration' => 30, 'status' => 'active'],
            ['name' => 'Potong Rambut Wanita', 'price' => 45000, 'duration' => 45, 'status' => 'active'],
            ['name' => 'Potong Rambut Anak', 'price' => 25000, 'duration' => 25, 'status' => 'active'],
            ['name' => 'Cuci Rambut', 'price' => 20000, 'duration' => 15, 'status' => 'active'],
            ['name' => 'Keramas', 'price' => 30000, 'duration' => 20, 'status' => 'active'],

            // Styling Services
            ['name' => 'Blow Styling', 'price' => 30000, 'duration' => 20, 'status' => 'active'],
            ['name' => 'Hair Styling', 'price' => 50000, 'duration' => 30, 'status' => 'active'],
            ['name' => 'Cetok Sisir', 'price' => 25000, 'duration' => 15, 'status' => 'active'],

            // Treatment Services
            ['name' => 'Creambath', 'price' => 60000, 'duration' => 60, 'status' => 'active'],
            ['name' => 'Hair Spa', 'price' => 80000, 'duration' => 90, 'status' => 'active'],
            ['name' => 'Hair Mask', 'price' => 70000, 'duration' => 45, 'status' => 'active'],
            ['name' => 'Scalp Treatment', 'price' => 90000, 'duration' => 60, 'status' => 'active'],
            ['name' => 'Hair Volume', 'price' => 85000, 'duration' => 60, 'status' => 'active'],

            // Chemical Services
            ['name' => 'Smoothing', 'price' => 180000, 'duration' => 120, 'status' => 'active'],
            ['name' => 'Keratin Treatment', 'price' => 250000, 'duration' => 150, 'status' => 'active'],
            ['name' => 'Hair Coloring', 'price' => 120000, 'duration' => 120, 'status' => 'active'],
            ['name' => 'Highlight', 'price' => 150000, 'duration' => 150, 'status' => 'active'],
            ['name' => 'Bleaching', 'price' => 100000, 'duration' => 90, 'status' => 'active'],

            // Special Services
            ['name' => 'Hair Extension', 'price' => 300000, 'duration' => 180, 'status' => 'active'],
            ['name' => 'Hair Tattoo', 'price' => 80000, 'duration' => 45, 'status' => 'active'],
            ['name' => 'Gunting Rambut Bayi', 'price' => 15000, 'duration' => 20, 'status' => 'active'],
        ];

        foreach ($treatments as $treatment) {
            Treatment::create($treatment);
        }

        $this->command->info('✅ ' . count($treatments) . ' treatments created successfully!');
    }
}