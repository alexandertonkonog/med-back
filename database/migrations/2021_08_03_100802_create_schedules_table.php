<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('deleted_at'); //дата окончания действия расписания
            $table->tinyInteger('working_days')->nullable(); //количество рабочих дней подряд
            $table->tinyInteger('weekends')->nullable(); //количество выходных дней подряд
            $table->tinyInteger('type')->default(1); //тип расписания - [недельное фиксированное, недельное, месячное]
            $table->smallInteger('offset')->nullable(); //сдвиг от даты создания до 1 рабочего дня 
            $table->json('schedule')->nullable(); //расписание по дням (если расписание фиксированное, то массив, если для каждого дня, то объект с ключами-датами)
            $table->integer('sheduleable_id');
            $table->string('sheduleable_type', 40);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
