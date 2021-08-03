<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('dateTime');
            $table->boolean('confirmed')->default(false);
            $table->string('comment')->nullable();
            $table->integer('doctor_id');
            $table->integer('service_id')->nullable();
            $table->string('external_id', 50)->nullable();
            $table->integer('specialization_id')->nullable();
            $table->integer('user_id');
            $table->integer('clinic_id');
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
        Schema::dropIfExists('appointments');
    }
}
