<?php

namespace Simplex\Auth\Auth;

use Simplex\Core\Identity\Models\User;
use Simplex\Core\Middleware\Handler;
use Simplex\Auth\Models\UserAuth;

class SessionMiddleware implements Handler
{

    /**
     * @inheritDoc
     */
    public function handle($payload, \Closure $next)
    {
        if ($payload) {
            return $next($payload);
        }
        $userId = SessionStorage::get();
        if ($userId) {
            $user = new User($userId);
            if ($user->getId()) {
                return $next($user);
            }
        }
        return $next($payload);
    }
}