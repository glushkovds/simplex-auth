<?php

namespace Simplex\Auth\Auth;

use Simplex\Core\Identity\Models\User;
use Simplex\Core\Middleware\Handler;
use Sumplex\Auth\Models\UserAuth;

class CookieMiddleware implements Handler
{

    /**
     * @inheritDoc
     */
    public function handle($payload, Handler $next)
    {
        if ($payload) {
            return $next->handle($payload);
        }
        $prefix = SF_LOCATION_SITE == SF_LOCATION ? 's' : 'a';
        $cookies = new CookieTokenBag($prefix);
        $token = $cookies->get();
        $modelAuth = UserAuth::findByToken($token);
        if ($modelAuth) {
            $user = new User($modelAuth['user_id']);
            if ($user->getId()) {
                $cookies->prolong();
                return $next->handle($user);
            }
        }
        return $next->handle($payload);
    }
}