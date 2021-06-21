<?php


namespace Simplex\Auth\Auth;


class CookieTokenBag extends CookieBag
{

    const COOKIE_NAME = 'sft';

    public function __construct($prefix)
    {
        parent::__construct($prefix);
        $this->cookies['token'] = new CookieItem($this->prefix . self::COOKIE_NAME);
    }

    public function get()
    {
        return $this->cookies['token']->getValue();
    }

    public function set($token)
    {
        $this->cookies['token']->setValue($token)->save();
    }


}