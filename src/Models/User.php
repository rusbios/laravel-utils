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

    const ROLE_DEFAULT = self::ROLE_USER;

    const ROLES = [
        self::ROLE_USER,
        self::ROLE_ADMIN,
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        'phone_verified_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function setPhoneAttribute($value)
    {
        $this->phone = (int) $value;
    }

    public function getPhoneAttribute()
    {
        return "+$this->phone";
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
