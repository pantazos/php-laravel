<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;

class ValidateUserRole
{
    public const ROLE = "User-Role";

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header(self::ROLE) == Role::CUSTOMER ||
            $request->header(self::ROLE) == Role::PROVIDER) {
            return $next($request);
        }

        return response(['message' => 'User role key must be sent in the request header'], 400);
    }
}
