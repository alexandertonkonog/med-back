<?php

namespace Database\Factories;

use App\Models\Connection;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConnectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Connection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'password' => $this->faker->firstname(),
            'login' => $this->faker->unique()->safeEmail(),
            'user_id' => \App\Models\User::get()->random()->id,
            'duration' => rand(0, 60),
            'url' => $this->faker->url(),
            'type_id' => rand(0, 60),
            'subtype_id' => rand(1, 5),
            'props' => json_encode(['name' => 'name']),
        ];
    }
}
