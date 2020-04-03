<?php

namespace RusBios\LUtils\Models;

use DateTime;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property int id
 * @property string name
 * @property string email
 * @property DateTime|null email_verified_at
 * @property string password
 * @property DateTime created_at
 * @property DateTime updated_at
 * @property string|null phone
 * @property DateTime|null phone_verified_at
 * @property string role
 */
class User extends \App\Models\User
{
    use SoftDeletes;

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const ROLE_MANAGER = 'manager';

    const ROLE_DEFAULT = self::ROLE_USER;

    const ROLES = [
        self::ROLE_USER,
        self::ROLE_MANAGER,
        self::ROLE_ADMIN,
    ];

    protected $casts = [
        'phone' => 'int',
        'email_verified_at' => 'datetime',
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        'phone_verified_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
    ];

    public function setPhoneAttribute($value)
    {
        if (static::validationPhone($value)) {
            $this->phone = (int) $value;
            return true;
        }

        return false;
    }

    /**
     * @param mixed $value
     * @return string|null
     */
    public function getPhoneAttribute($value)
    {
        return $value ? "+$value" : null;
    }

    /**
     * @return string
     */
    public static function genPassword()
    {
        return Str::random(8);
    }

    /**
     * @param string $phone
     * @return bool
     */
    public static function validationPhone($phone)
    {
        return strlen((int) $phone) === 11;
    }

    public function isAdmin()
    {
        return $this->role == self::ROLE_ADMIN;
    }
}
