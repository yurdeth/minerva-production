<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware {
    public function handle(Request $request, Closure $next, $role) {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (Auth::user()->roles_id != 1) {
            return redirect(route("inicio"));
        }

        return $next($request);
    }
}
