<?php

namespace App\Http\Api\Middleware\Client;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;

class CheckClientAddressMiddleware extends Middleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        if (! current_user()->address()->exists()) {
            return \response()->json([
                'message' => 'Você deve cadastrar um endereço antes de continuar.',
            ], Response::HTTP_NOT_FOUND);
        }

        return $next($request);
    }
}
