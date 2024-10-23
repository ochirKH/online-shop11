<?php

namespace Core;

class Autoload
{
    public static function registrate($rootPath)
    {
        $autoload = function ($className) use ($rootPath){
            $path = str_replace('\\', '/', $className);
            $path = $rootPath . $path . ".php";
            if (file_exists($path)) {
                require_once $path;
                return true;
            }
            return false;
        };

        spl_autoload_register($autoload);
    }
}