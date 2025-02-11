<?php

namespace App\Http\Shared\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $userRoles = $request->user()->roles;

        foreach ($userRoles as $role) {
            if (in_array($role->name, $roles, true)) {
                return $next($request);
            }
        }

        return response()->json([
            'message' => __('custom.forbidden_route_according_to_current_user_role'),
        ], 403);
    }
}
