<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'dateTime' => $this->faker->dateTime(),
            'doctor_id' => \App\Models\Doctor::get()->random()->id,
            'user_id' => \App\Models\User::get()->random()->id,
            'service_id' => \App\Models\Service::get()->random()->id,
            'specialization_id' => \App\Models\Specialization::get()->random()->id,
            'clinic_id' => \App\Models\Clinic::get()->random()->id,
            'comment' => $this->faker->text(200),
            'external_id' => $this->faker->text(50),
        ];
    }
}
