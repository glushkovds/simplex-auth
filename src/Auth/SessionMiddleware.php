<?php

namespace Simplex\Auth\Auth;

use Simplex\Auth\SessionStorage;
use Simplex\Core\Models\User;

class SessionMiddleware extends BaseMiddleware
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
            /** @var User $user */
            $user = new $this->userModelClass($userId);
            if ($user->getId()) {
                return $next($user);
            }
        }
        return $next($payload);
    }
}