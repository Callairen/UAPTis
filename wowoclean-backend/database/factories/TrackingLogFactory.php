<?php

namespace Database\Factories;

use App\Models\TrackingLog;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackingLogFactory extends Factory
{
    protected $model = TrackingLog::class;

    public function definition(): array
    {
        return [
            'location' => $this->faker->city(),
            'timestamp' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'description' => $this->faker->sentence(5),
        ];
    }
}