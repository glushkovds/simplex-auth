<?php

namespace Simplex\Auth\SignOut;

use Simplex\Auth\SessionStorage;
use Simplex\Core\Middleware\Handler;

class SessionMiddleware implements Handler
{

    /**
     * @inheritDoc
     */
    public function handle($payload, \Closure $next)
    {
        SessionStorage::set(null);
        return $next($payload);
    }
}