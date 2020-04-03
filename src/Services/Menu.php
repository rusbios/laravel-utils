<?php

namespace RusBios\LUtils\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Menu
{
    protected const BASE_NAME_CACHE = 'rb_admin_menu';

    public function __construct()
    {
        //if (\config('app.env') == 'local') Menu::clean();
    }

    /**
     * @param string $url
     * @param string $name
     * @param string|null $description
     * @param int|null $order
     * @param bool $enabled
     * @return bool
     * @throws \Exception
     */
    public function add($url, $name, $description = null, int $order = null, bool $enabled = true)
    {
        $menu = $this->getArray();
        $menu[$url] = [
            'url' => $url,
            'name' => $name,
            'description' => $description,
            'enabled' => $enabled,
            'order' => $order,
        ];
        return Cache::put(static::BASE_NAME_CACHE, $menu, (new \DateTime())->setTime(23, 59, 59));
    }

    private function getArray()
    {
        return Cache::get(static::BASE_NAME_CACHE, []);
    }

    /**
     * @return array
     */
    public function get()
    {
        $result = [];
        foreach ($this->getArray() as $menu) {
            if (false && $this->isAccess($menu['url'])) {
                continue;
            }
            $menu['active'] = $this->isActive($menu['url']);
            $result[$menu['order']] = $menu;
        }
        sort($result);

        return $result;
    }

    /**
     * @param string $url
     * @return bool
     */
    protected function isActive($url)
    {
        return request()->path() == $url;
    }

    /**
     * @param string $url
     * @return bool
     */
    protected function isAccess($url)
    {
        return Auth::check();
    }

    public static function clean()
    {
        Cache::put(static::BASE_NAME_CACHE, [], 0);
    }
}
