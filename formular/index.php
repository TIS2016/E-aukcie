<?php

define('PROJECT_ROOT', __DIR__);

function my_autoLoader($className)
{
    $file = __DIR__ . '/classes/' . strtr($className, array('\\' => DIRECTORY_SEPARATOR)) . '.php';
    require($file);
}

spl_autoload_register('my_autoLoader');
$contentManager = ContentManager::getInstance();
$contentManager->prepare();
$contentManager->show();
