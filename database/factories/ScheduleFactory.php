<?php

namespace Database\Factories;

use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = rand(1,3);
        $firstDay = $type === 2 ? new \DateTime() : null;
        $schedule = [];
        $max = $format = null;
        $date = new \DateTime();
        
        if ($type === 1) {
            $format = '0.1.1.1.0.1.1';
            $max = 5;
        } else if ($type === 2) {
            $min = rand(0, 7);
            $format =  $min . '/' . rand(0, 7);
            $max = $min;
        } else {
            $max = 31;
        }
        for($i = 0; $i < $max; $i++) {
            $schedule[] = ['date' => $date->modify('+1 day')->format('Y-m-d\TH:i:s.u'), 'start' => '0000-00-00T08:00:00', 'end' => '0000-00-00T17:00:00'];
        }
        $finish = $this->faker->dateTime('2050-05-07');
        return [
            'month' => $type === 3 ? $finish : null,
            'type' => $type,
            'format' => $format,
            'first_day' => $firstDay,
            'schedule' => json_encode($schedule),
            'scheduleable_id' => \App\Models\Doctor::get()->random()->id,
            'scheduleable_type' => \App\Models\Doctor::class,
            'user_id' => \App\Models\User::get()->random()->id
        ];
    }
}
