<?php

namespace CodeFlix\Http\Middleware;

use Closure;
use CodeFlix\Exceptions\SubscriptionInvalidExeption;

class CheckSubscriptions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user('api');
        $valid = $user->hasSubscriptionValid();
        if (!$valid){
            throw new SubscriptionInvalidExeption("User is not a valid subscription");
        }
        return $next($request);
    }
}
