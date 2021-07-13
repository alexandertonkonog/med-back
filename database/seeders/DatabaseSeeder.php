<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Service::factory(100)->create();
        \App\Models\Clinic::factory(100)->create();
        \App\Models\Doctor::factory(50)->create();
        \App\Models\Specialization::factory(100)->create();
        \App\Models\File::factory(10)->create();
    }
}
