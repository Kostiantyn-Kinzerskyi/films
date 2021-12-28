<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

define("PROJECTPATH", str_replace('\\', '/', dirname(__DIR__)));
define("APPATH", PROJECTPATH."/application");
require APPATH.'/lib/Dev.php';

use application\core\Router;

spl_autoload_register(function($class) {
    $path = PROJECTPATH.'/'.str_replace('\\', '/', $class.'.php');
    if (file_exists($path)) {
        require $path;
    }
});
require APPATH.'/lib/Usrs.php';
session_start();

$router = new Router;
$router->run();