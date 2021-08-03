<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            $table->string('login', 50)->nullable();
            $table->string('url')->nullable();
            $table->string('duration', 20)->nullable();
            $table->string('password', 50)->nullable();
            $table->tinyInteger('type_id');
            $table->string('subtype_id', 10)->nullable();
            $table->integer('user_id');
            $table->json('props')->nullable();
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
        Schema::dropIfExists('connections');
    }
}
