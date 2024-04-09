<?php

namespace App\Http\Middleware;

use App\Types\RoleType;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectConGuideIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if ($user && $user->hasRole([RoleType::SUPER_ADMIN->value()])) {
            return $next($request);

        }

        // TODO: Redirect to con guide
        return redirect()->route('home');

    }
}
