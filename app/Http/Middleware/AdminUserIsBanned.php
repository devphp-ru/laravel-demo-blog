<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminUserIsBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('admin')->check() && auth('admin')->user()->is_banned) {
            auth('admin')->logout();

            return redirect()->route('admin.login.form')->withErrors(['error' => 'Досутп запрещен.']);
        }

        return $next($request);
    }

}
