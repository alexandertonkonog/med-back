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
            'path' => $this->faker->image(),
            'disk' => 'public',
            'fileable_id' => \App\Models\Doctor::get()->random()->id,
            'fileable_type' => \App\Models\Doctor::class,
            'imgable_id' => \App\Models\User::get()->random()->id,
            'imgable_type' => 'doctor'
        ];
    }
}
