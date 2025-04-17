<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $role = $user->getRole();
        if (Auth::user()->isAdmin()) {
            return $next($request);
        }else{
            $permissionCheck = $role->hasPermission($request->route()->getName());
            if ($permissionCheck) {
                return $next($request);
            }else{
                abort(401);
            }
        }
    }
}
