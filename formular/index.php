<?php

use Controller\ErrorController;
use Controller\FooterController;
use Controller\HeadController;
use Controller\NavController;

define('PROJECT_ROOT', __DIR__);

$url = explode('/', $_SERVER['REQUEST_URI']);


function my_autoLoader($className)
{
    $file = __DIR__ . '/classes/' . strtr($className, array('\\' => DIRECTORY_SEPARATOR)) . '.php';
    require($file);
}

spl_autoload_register('my_autoLoader');

$controllers = array('Controller\\FormController');

$head = new HeadController();
$nav = new NavController();
$footer = new FooterController();

echo $head->doShow();
echo $nav->doShow();

foreach ($controllers as $controllerClass) {
    $action = $controllerClass::getAction($url);
    if ($action !== null) {
        $controller = new $controllerClass();
        $functionName = 'do' . ucfirst($action);
        echo $controller->$functionName($url);
        break;
    }
}


if (!isset($functionName)) {
    header('HTTP/1.1 404 Not Found');
    $controller = new ErrorController();
    echo $controller->doNotFound($url);
}
echo $footer->doShow();