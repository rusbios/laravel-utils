<?php

namespace RusBios\LUtils\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

class AdminController extends Controller
{
    public function home()
    {
        return view('rb_admin::home');
    }

    static function route()
    {
        Route::get('admin', sprintf('%s@%s', static::class, 'home'))
            //->middleware('rb_admin')
            ->name('admin-home');
    }
}
