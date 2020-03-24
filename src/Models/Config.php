<?php

namespace RusBios\LUtils\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config as FConfig;

/**
 * @method static Config find(int $id)
 * @property int id
 * @property string key
 * @property int parent_id
 * @property string value
 */
class Config extends Model
{
    protected $table = 'configs';

    const CREATED_AT = null;
    const UPDATED_AT = null;

    /**
     * load all configuration or parent and child
     *
     * @param string|null $path
     * @param int|null $id
     */
    public static function loadAll($path = null, $id = null)
    {
        $configs = $id ? [static::find($id)] : static::query()->whereNull('parent_id')->get();
        foreach ($configs as $config) {
            $newPath = join('.', array_filter([$path, $config->key]));
            FConfig::push($newPath, $config->value);
            //static::loadAll($newPath, $config->id);
        }
    }
}
