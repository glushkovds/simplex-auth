<?php


namespace Simplex\Auth\Auth;

use Simplex\Core\Models\User;
use Simplex\Core\Middleware\Handler;

class BasicAuthMiddleware implements Handler
{

    /**
     * @inheritDoc
     */
    public function handle($payload, \Closure $next)
    {
        if ($payload) {
            return $next($payload);
        }
        $login = $_SERVER['PHP_AUTH_USER'] ?? null;
        $pass = $_SERVER['PHP_AUTH_PW'] ?? null;
        if ($login && $pass) {
            $user = User::findOne(['login' => $login, 'password' => md5($pass)]);
            if ($user) {
                return $next($user);
            }
        }
        return $next($payload);
    }

}