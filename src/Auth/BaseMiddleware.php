<?php


namespace Simplex\Auth\Auth;


use Simplex\Core\Middleware\Handler;
use Simplex\Core\Models\User;

abstract class BaseMiddleware implements Handler
{

    /**
     * @var User
     */
    protected $userModelClass = User::class;

    /**
     * @param string $userModelClass
     */
    public function setUserModelClass($userModelClass): void
    {
        $this->userModelClass = $userModelClass;
    }

}