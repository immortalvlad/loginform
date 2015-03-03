<?php

class Hash {

    public static function make($string, $salt = '')
    { 
        return hash('sha256', $string . $salt);
    }
    public static function md5make($string)
    {
         return md5($string);
    }

    public static function salt()
    {
        return mt_rand(0, 1000000);
    }

    public static function unique()
    {
        return self::make(uniqid());
    }

}
