<?php

/**
 * Description of Message
 *
 * @author immortalvlad
 */
class Message {

    public static function show($name = '', $string = '')
    {
        if ($string && $name)
        {
            Session::init()->set($name, $string);
        } else
        {
            if (Session::init()->isExists($name))
            {
                $message = Session::init()->get($name);
                Session::init()->deleteSession($name);
                return $message;
            } 
        }
    }

}
