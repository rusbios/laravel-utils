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
}
