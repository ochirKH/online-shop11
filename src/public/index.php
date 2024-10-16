<?php

//$autoloadController = function ($className) {
//    $path = "./../Controller/$className.php";
//    if (file_exists($path)) {
//        require_once $path;
//        return true;
//    }
//    return false;
//};
//$autoloadModel = function ($className) {
//    $path = "./../Model/$className.php";
//    if (file_exists($path)) {
//        require_once $path;
//        return true;
//    }
//    return false;
//};
//$autoloadApp = function ($className) {
//    $path = "./../Core/$className.php";
//    if (file_exists($path)) {
//        require_once $path;
//        return true;
//    }
//    return false;
//};

$autoload = function ($className) {
    $path = str_replace('\\', '/', $className);
    $path = "./../$path.php";
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    return false;
};


spl_autoload_register($autoload);


$app = new \Core\App();
$app->run();
