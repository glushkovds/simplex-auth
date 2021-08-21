<?php


namespace Simplex\Auth\Auth;


use Simplex\Core\Container;
use Simplex\Core\Identity\Models\User;
use Simplex\Core\Middleware\Chain;
use Simplex\Core\UserInstance;

class Init
{
    public static function byMiddlewareChain(Chain $chain)
    {
        $user = $chain->process(null);
//        var_dump($userModel);
        Container::set('user', $user ?? new \Simplex\Core\Identity\Models\User());
        static::initLegacy($user);
    }

    public static function byUser(User $user)
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
}