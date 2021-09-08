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
            $table->string('format', 20)->nullable(); //формат расписания
            $table->tinyInteger('type')->default(1); //тип расписания - [недельное, сменное, месячное]
            $table->date('month'); //месяц расписания - для месячного
            $table->date('first_day')->nullable(); //дата первого рабочего дня для сменного расписания 
            $table->json('schedule'); //расписание по дням (если расписание фиксированное, то массив, если для каждого дня, то объект с ключами-датами)
            $table->integer('scheduleable_id');
            $table->integer('user_id');
            $table->string('scheduleable_type', 40);
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
