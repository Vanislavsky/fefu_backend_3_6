<?php

namespace App\Http\Middleware;

class MaybeAuthenticate extends Authenticate
{
    public function authenticate($request, array $guards): void
    {
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $this->auth->shouldUse($guard);
                break;
            }
        }
    }
}
