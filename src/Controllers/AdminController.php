<?php

namespace RusBios\LUtils\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use RusBios\LUtils\Services\Head;
use RusBios\LUtils\Services\Menu;

class AdminController extends Controller
{
    /** @var string */
    const MENU_NAME = 'RB home';

    /** @var string */
    const MENU_DESCRIPTION = 'Главная страница админки';

    public function home()
    {
        Head::setTitle(self::MENU_NAME);
        Head::setDescription(self::MENU_DESCRIPTION);
        return view('rb_admin::home');
    }

    static function route()
    {
        app()->make(Menu::class)->add(
            env('RB_BASE_URI_ADMIN', 'admin'),
            static::MENU_NAME,
            static::MENU_DESCRIPTION,
            1
        );

        Route::get('admin', sprintf('%s@%s', static::class, 'home'))
            //->middleware('rb_admin')
            ->name('admin-home');
    }
}
