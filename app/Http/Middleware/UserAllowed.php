<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthenticationException;
use App\User;
use Closure;

class UserAllowed
{
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        if (!$request->has('id')) {
            throw new AuthenticationException('User is not specified');
        }

        if (!User::where('id', $request->get('id'))) {
            throw new AuthenticationException('User is not allowed or does not exist');
        }

        return $next($request);
    }
}
