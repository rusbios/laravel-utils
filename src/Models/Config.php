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
     * @param array|null $path
     * @param int|null $id
     */
    public static function loadAll(array $path = [], $id = null)
    {
        $configs = $id ? [static::find($id)] : static::query()->whereNull('parent_id')->get();
        foreach ($configs as $config) {
            $newPath = array_filter($path);
            $newPath[] = $config->key;
            if ($config->value) FConfig::set(join('.', $newPath), $config->value);
            foreach ($config->getChild()->get() as $childConfig) {
                static::loadAll($newPath, $childConfig->id);
            }
        }
    }

    public function getParent()
    {
        return $this->hasOne(self::class, 'id', 'parent_id');
    }

    public function getChild()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
