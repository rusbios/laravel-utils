<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RusBios\LUtils\Models\Config;
use RusBios\LUtils\Services\Head;

class CreateConfigTable extends Migration
{
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->index();
            $table->integer('parent_id', false, true)->nullable();
            $table->string('value', 1000)->nullable();

            $table->foreign('parent_id')->references('id')->on('configs');
        });

        DB::transaction(function () {
            $headId = Config::query()->insertGetId(['key' => 'head']);
            $systemId = Config::query()->insertGetId(['key' => 'system']);
            Config::query()->insert([
                ['key' => 'title', 'parent_id' => $headId, 'value' => config('app.name')],
                ['key' => 'description', 'parent_id' => $headId, 'value' => null],
                ['key' => 'keywords', 'parent_id' => $headId, 'value' => null],
                ['key' => 'image', 'parent_id' => $headId, 'value' => null],
                ['key' => 'url', 'parent_id' => $headId, 'value' => config('add.url')],
                ['key' => 'robots', 'parent_id' => $headId, 'value' => Head::ROBOTS_NOINDEX],
                ['key' => 'type', 'parent_id' => $headId, 'value' => Head::DEFAULT_TYPE],
                ['key' => 'rb_menu_cache', 'parent_id' => $systemId, 'value' => false],
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('configs');
    }
}
