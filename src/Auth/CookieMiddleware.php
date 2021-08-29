<?php

namespace Simplex\Auth\Auth;

use Simplex\Auth\CookieTokenBag;
use Simplex\Core\Models\User;
use Simplex\Auth\Models\UserAuth;

class CookieMiddleware extends BaseMiddleware
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
                /** @var User $user */
                $user = new $this->userModelClass($modelAuth['user_id']);
                if ($user->getId()) {
                    $cookies->prolong();
                    return $next($user);
                }
            }
        }
        return $next($payload);
    }
}