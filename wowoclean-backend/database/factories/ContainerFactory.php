<?php

namespace Database\Factories;

use App\Models\Container;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContainerFactory extends Factory
{
    protected $model = Container::class;

    public function definition(): array
    {
        $types = ['Chemical', 'Medical', 'Flammable', 'Toxic'];
        $chosenType = $this->faker->randomElement($types);
        $weight = ($chosenType === 'Chemical') ? $this->faker->numberBetween(10, 1000) : $this->faker->numberBetween(10, 5000);

        return [
            'container_id' => strtoupper(Str::random(2)) . $this->faker->unique()->numberBetween(10000, 99999),
            'waste_type' => $chosenType,
            'weight_kg' => $weight,
            'status' => $this->faker->randomElement(['Active', 'Archived']),
        ];
    }
}