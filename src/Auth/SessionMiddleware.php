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
        $prefix = SF_LOCATION_SITE == SF_LOCATION ? 's' : 'a';
        $userId = $_SESSION[$prefix . '_user_id'] ?? null;
        if ($userId) {
            $user = new User($userId);
            if ($user->getId()) {
                return $next($user);
            }
        }
        return $next($payload);
    }
}