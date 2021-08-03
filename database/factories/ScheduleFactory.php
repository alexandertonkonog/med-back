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
        $offset = $type === 1 ? 0 : rand(1,3);
        $schedule = [];
        $work = $week = $max = null;
        $date = new \DateTime();
        if ($type === 1) {
            $max = 5;
        } else if ($type === 2) {
            $max = 7;
        } else {
            $max = 31;
        }
        for($i = 0; $i < $max; $i++) {
            $schedule[$date->modify('+1 day')->format('Y-m-d\TH:i:s.u')] = ['start' => '0000-00-00T08:00:00', 'end' => '0000-00-00T17:00:00'];
        }
        if ($type === 1) {
            $work = 5;
            $week = 2;
            
        } else {
            $work = rand(1,6);
            $week = 7 - $work;
        }
        return [
            'deleted_at' => $this->faker->dateTime('2050-05-07'),
            'type' => $type,    
            'offset' => $offset,
            'working_days' => $work,
            'weekends' => $week,
            'schedule' => json_encode($schedule),
            'sheduleable_id' => \App\Models\User::get()->random()->id,
            'sheduleable_type' => \App\Models\User::class
        ];
    }
}
