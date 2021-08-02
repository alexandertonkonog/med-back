<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->title(),
            'external_id' => $this->faker->unique()->safeEmail(),
            'user_id' => \App\Models\User::get()->random()->id,
            'cost' => rand(1000, 3000),
            'duration' => rand(15, 120),
            'code' => $this->faker->unique()->safeEmail(),
        ];
    }
}
