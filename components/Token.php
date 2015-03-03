<?php

class Token {

    public static function generate()
    {       
        return Session::init()->set(Config::get('token_name'), md5(uniqid()));
    }

    public static function isValid($token)
    {
        $tokenName = Config::get("token_name");

        if (Session::init()->isExists($tokenName) && $token === Session::init()->get($tokenName))
        {
            Session::init()->deleteSession($tokenName);
            return true;
        }
        return false;
    }

}
