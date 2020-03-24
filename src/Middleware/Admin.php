<?php

namespace RusBios\LUtils\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use RusBios\LUtils\Models\User;

class Admin extends Middleware
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check() && User::find(Auth::id())->isAdmin()) {
            return $next($request);
        }

        return redirect()->route('admin');
    }
}
