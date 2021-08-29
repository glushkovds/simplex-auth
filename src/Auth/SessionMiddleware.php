<?php

namespace Simplex\Auth\Auth;

use Simplex\Auth\SessionStorage;
use Simplex\Core\Identity\Models\User;
use Simplex\Core\Middleware\Handler;

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