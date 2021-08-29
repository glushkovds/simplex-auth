<?php


namespace Simplex\Auth\Auth;


use Simplex\Core\Models\User;

class Chain extends \Simplex\Core\Middleware\Chain
{
    /**
     * @var User
     */
    protected $userModelClass = User::class;

    /**
     * @param string $class subclass of Simplex\Core\Models\User
     * @return $this
     */
    public function setUserModelClass($class)
    {
        if ($class && !is_subclass_of($class, User::class)) {
            throw new \InvalidArgumentException("userModelClass must be sublass of Simplex\Core\Models\User");
        }
        $this->userModelClass = $class;
        return $this;
    }

    public function process($payload = null)
    {
        foreach ($this->middlewares as $mw) {
            if ($mw instanceof BaseMiddleware) {
                $mw->setUserModelClass($this->userModelClass);
            } else {
                throw new \InvalidArgumentException("All middlewares must be sublass of Simplex\Auth\Auth\BaseMiddleware");
            }
        }
        return parent::process($payload);
    }

    /**
     * @return User
     */
    public function getUserModelClass(): User
    {
        return $this->userModelClass;
    }

}