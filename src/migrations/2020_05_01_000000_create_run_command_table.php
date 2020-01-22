<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRunCommandTable extends Migration
{
    public function up()
    {
        Schema::create('run_command', function (Blueprint $table) {
            $table->increments('id');
            $table->string('command');
            $table->json('arguments');
            $table->integer('pid')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('run_command');
    }
}
