<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigTable extends Migration
{
    public function up()
    {
        Schema::create('config', function (Blueprint $table) {
            $table->string('name')->unique()->index();
            $table->timestamps();
            $table->json('param');
        });
    }

    public function down()
    {
        Schema::dropIfExists('config');
    }
}
