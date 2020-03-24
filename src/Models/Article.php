<?php

namespace RusBios\LUtils\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static Article find(int $id)
 * @property int id
 * @property bool disabled
 * @property string title
 * @property string text
 * @property string|null description
 * @property string|null keywords
 * @property string uri
 * @property int author_id
 * @property DateTime created_at
 * @property DateTime updated_at
 * @property DateTime|null deleted_at
 */
class Article extends Model
{
    use SoftDeletes;

    const LIB_TRANSLIT = [
        'Ё' => 'YO',
        'Й' => 'J',
        'Ц' => 'C',
        'У' => 'U',
        'К' => 'K',
        'Е' => 'E',
        'Н' => 'N',
        'Г' => 'G',
        'Ш' => 'SH',
        'Щ' => 'SHCH',
        'З' => 'Z',
        'Х' => 'H',
        'Ъ' => '',
        'Ф' => 'F',
        'Ы' => 'Y',
        'В' => 'V',
        'А' => 'A',
        'П' => 'P',
        'Р' => 'R',
        'О' => 'O',
        'Л' => 'L',
        'Д' => 'D',
        'Ж' => 'ZH',
        'Э' => 'EH',
        'Я' => 'YA',
        'Ч' => 'CH',
        'С' => 'S',
        'М' => 'M',
        'И' => 'I',
        'Т' => 'T',
        'Ь' => '',
        'Б' => 'B',
        'Ю' => 'yu',
        'ё' => 'yo',
        'й' => 'j',
        'ц' => 'c',
        'у' => 'u',
        'к' => 'k',
        'е' => 'e',
        'н' => 'n',
        'г' => 'g',
        'ш' => 'sh',
        'щ' => 'shch',
        'з' => 'z',
        'х' => 'h',
        'ъ' => '',
        'ф' => 'f',
        'ы' => 'y',
        'в' => 'v',
        'а' => 'a',
        'п' => 'p',
        'р' => 'r',
        'о' => 'o',
        'л' => 'l',
        'д' => 'd',
        'ж' => 'zh',
        'э' => 'eh',
        'я' => 'ya',
        'ч' => 'ch',
        'с' => 's',
        'м' => 'm',
        'и' => 'i',
        'т' => 't',
        'ь' => '',
        'б' => 'b',
        'ю' => 'yu'
    ];

    protected $table = 'articles';

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * @param string $uri
     * @return Article|null
     */
    public static function getByUri($uri)
    {
        return static::query()
            ->where('uri', $uri)
            ->whereNull('deleted_at')
            ->first();
    }

    /**
     * @param string $title
     * @return string
     */
    public static function uriGen($title)
    {
        return strtr($title, self::LIB_TRANSLIT);
    }

    /**
     * @param array $option
     * @return bool|void
     */
    public function save($option = [])
    {
        if (!$this->uri) $this->uri = self::uriGen($this->title);
        return parent::save($option);
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, 'author_id');
    }
}
