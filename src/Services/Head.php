<?php

namespace RusBios\LUtils\Services;

use Illuminate\Support\Facades\Config;

class Head
{
    const DEFAULT_TYPE = 'website';
    const ROBOTS_INDEX = 'INDEX,FOLLOW';
    const ROBOTS_NOINDEX = 'NOINDEX,FOLLOW';

    /**
     * @param string $title
     */
    public static function setTitle($title)
    {
        Config::set('head.title', $title);
    }

    /**
     * @param string $description
     * @return bool
     */
    public static function setDescription($description)
    {
        if (mb_strlen($description) <= 300) {
            Config::set('head.description', $description);
            return true;
        }
        return false;
    }

    /**
     * @param string $keywords
     */
    public static function setKeywords($keywords)
    {
        Config::set('head.keywords', $keywords);
    }

    /**
     * @param string|null $imgPath
     */
    public static function setImage($imgPath = null)
    {
        if ($imgPath && file_exists(public_path($imgPath))) {
            Config::set('head.image', $imgPath);
        }
        Config::set('head.image', null);
    }

    /**
     * @param string|null $uri
     */
    public static function setUrl($uri = null)
    {
        Config::set('head.url', join('/', array_filter([
            \config('add.url'),
            $uri
        ])));
    }

    /**
     * @param string|null $type
     */
    public static function setType($type = null)
    {
        Config::set('head.type', $type ?: static::DEFAULT_TYPE);
    }

    /**
     * @param bool $index
     */
    public static function setRobots($index = false)
    {
        Config::set('head.robots', $index ? static::ROBOTS_INDEX : static::ROBOTS_NOINDEX);
    }

    /**
     * @param string $message
     * @param string $type
     */
    public static function addMessage($message, $type = 'info')
    {
        $messages = request()->session()->get('messages', []);
        $messages[] = [
            'text' => $message,
            'type' => $type,
        ];
        request()->session()->put('messages', $messages);
    }

    /**
     * @return array
     */
    public static function getMessages()
    {
        $messages = request()->session()->get('messages', []);
        request()->session()->remove('messages');
        return $messages;
    }
}
