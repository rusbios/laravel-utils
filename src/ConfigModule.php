<?php

namespace RusBios\LUtils;

use DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string key
 * @property int|null parent_id
 * @property string value
 */
class ConfigModule extends Model
{
    protected $table = 'config';
    protected $timestamps = false;

    public function getParent()
    {
        return $this->hasOne(self::class, 'parent_id');
    }

    public function getChild()
    {
        return $this->hasMany(self::class, 'id', 'parent_id');
    }
}
