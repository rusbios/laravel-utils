<?php

namespace RusBios\LUtils\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use RusBios\LUtils\Models\User;

class Admin extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::check() && User::find(Auth::id())->isAdmin()) {
            return $next($request);
        }
        return redirect()->route('authForm');
    }
}
