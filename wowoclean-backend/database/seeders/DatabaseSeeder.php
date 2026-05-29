<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Container;
use App\Models\TrackingLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin WowoClean',
            'email' => 'admin@wowoclean.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Operator Lapangan',
            'email' => 'user@wowoclean.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);

        $container1 = Container::create([
            'container_id' => 'WH12345',
            'waste_type' => 'Plastic',
            'weight_kg' => 500,
            'status' => 'Active',
        ]);

        TrackingLog::create([
            'container_id' => $container1->id,
            'location' => 'Gudang Utama',
            'timestamp' => now()->subDays(2),
            'description' => 'Kontainer diterima di gudang utama',
        ]);

        $container2 = Container::create([
            'container_id' => 'CH98765',
            'waste_type' => 'Chemical',
            'weight_kg' => 800,
            'status' => 'Active',
        ]);

        TrackingLog::create([
            'container_id' => $container2->id,
            'location' => 'Fasilitas Transit A',
            'timestamp' => now()->subDay(),
            'description' => 'Pemeriksaan keamanan bahan kimia selesai',
        ]);
    }
}