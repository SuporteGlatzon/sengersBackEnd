<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckActiveUser
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->active) {
            auth()->logout();

            // Check if it's an API request
            if ($request->expectsJson() || $request->is("api/*")) {
                return response()->json(
                    [
                        "message" =>
                            "Sua conta está inativa. Entre em contato com o administrador.",
                    ],
                    403
                );
            }

            // For web requests
            return redirect()
                ->route("login")
                ->withErrors([
                    "email" =>
                        "Sua conta está inativa. Entre em contato com o administrador.",
                ]);
        }

        return $next($request);
    }
}
