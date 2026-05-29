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
            'name' => 'Administrator System',
            'email' => 'admin@wowoclean.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Field Operator',
            'email' => 'user@wowoclean.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);

        Container::factory()
            ->count(20)
            ->create()
            ->each(function ($container) {
                TrackingLog::factory()
                    ->count(rand(1, 4))
                    ->create(['container_id' => $container->container_id]);
            });
    }
}