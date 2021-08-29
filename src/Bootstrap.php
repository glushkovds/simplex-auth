<?php


namespace Simplex\Auth;


use Simplex\Auth\Auth\Chain;
use Simplex\Auth\SignOut\CookieMiddleware;
use Simplex\Auth\SignOut\SessionMiddleware;
use Simplex\Core\Container;
use Simplex\Core\Models\User;
use Simplex\Core\UserInstance;

class Bootstrap
{
    public static function authByMiddlewareChain(Chain $chain)
    {
        $user = $chain->process(null);
        Container::set('user', $user ?? new ($chain->getUserModelClass())());
        static::initLegacy($user);
    }

    public static function authByUser(User $user)
    {
        Container::set('user', $user);
        static::initLegacy($user);
    }

    protected static function initLegacy(?User $user)
    {
        Container::set('userLegacy', \Simplex\Core\User::class);
        if (empty($user)) {
            return;
        }
        $userInstance = new UserInstance('', '', '', '', '');
        if ($user) {
            $userInstance->initByModel($user);
        }
        \Simplex\Core\User::login($userInstance);
    }

    public static function signOut()
    {
        (new Chain([
            new SessionMiddleware(),
            new CookieMiddleware(),
        ]))->process();
        Container::set('user', new (get_class(Container::getUser()))());
        Container::getUserLegacy()::logout();
    }
}