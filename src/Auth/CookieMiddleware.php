<?php

namespace Simplex\Auth\Auth;

use Simplex\Auth\CookieTokenBag;
use Simplex\Core\Identity\Models\User;
use Simplex\Core\Middleware\Handler;
use Simplex\Auth\Models\UserAuth;

class CookieMiddleware implements Handler
{

    /**
     * @inheritDoc
     */
    public function handle($payload, \Closure $next)
    {
        if ($payload) {
            return $next($payload);
        }
        $cookies = new CookieTokenBag(CookieTokenBag::defaultPrefix());
        $token = $cookies->get();
        if ($token) {
            $modelAuth = UserAuth::findByToken($token);
            if ($modelAuth) {
                $user = new User($modelAuth['user_id']);
                if ($user->getId()) {
                    $cookies->prolong();
                    return $next($user);
                }
            }
        }
        return $next($payload);
    }
}