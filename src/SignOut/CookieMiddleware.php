<?php

namespace Simplex\Auth\SignOut;

use Simplex\Auth\CookieTokenBag;
use Simplex\Core\Middleware\Handler;

class CookieMiddleware implements Handler
{

    /**
     * @inheritDoc
     */
    public function handle($payload, \Closure $next)
    {
        $cookies = new CookieTokenBag(CookieTokenBag::defaultPrefix());
        $cookies->delete();
        return $next($payload);
    }
}