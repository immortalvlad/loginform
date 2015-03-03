<?php

spl_autoload_register('autoload');

use components\Auth\B;
new B();
//new \components\Auth\A();
//new B();
//new \components\Auth\B();
//new B();

function autoload($className)
{   
    echo strpos($className, '\\')."<br>";
    $className = ltrim($className, '\\');
    $fileName = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\'))
    {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    require $fileName;
}
