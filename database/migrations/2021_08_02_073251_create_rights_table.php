<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rights', function (Blueprint $table) {
            $table->id();
            $table->integer('rightable_id');
            $table->string('rightable_type', 20);
            $table->string('user', 10);
            $table->string('clinic', 10);
            $table->string('ref', 10);
            $table->string('connection', 10);
            $table->string('doctor', 10);
            $table->string('specialization', 10);
            $table->string('file', 10);
            $table->string('order', 10);
            $table->string('service', 10);
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
        Schema::dropIfExists('rights');
    }
}
