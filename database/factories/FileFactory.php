<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->title(),
            'url' => $this->faker->image(),
            'user_id' => \App\Models\User::get()->random()->id,
            'clinic_id' => \App\Models\Clinic::get()->random()->id,
            'service_id' => \App\Models\Service::get()->random()->id,
            'doctor_id' => \App\Models\Doctor::get()->random()->id,
        ];
    }
}
