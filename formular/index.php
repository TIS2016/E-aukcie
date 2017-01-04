<?php

//use PdfGen\AuctionPdf;

session_start();

if (isset($_POST['logoutbtn'])) {
    session_unset();
}

//print_r($_SESSION);

define('PROJECT_ROOT', __DIR__);

$config = parse_ini_file("config.ini", true);
define('FIRST_URL_INDEX', $config['url']['urlIndex']);
define('DB_HOST', $config['database']['host']);
define('DB_NAME', $config['database']['dbname']);
define('DB_LOGIN', $config['database']['login']);
define('DB_PASSWORD', $config['database']['password']);


function my_autoLoader($className)
{
    $file = __DIR__ . '/classes/' . strtr($className, array('\\' => DIRECTORY_SEPARATOR)) . '.php';
    require($file);
}

spl_autoload_register('my_autoLoader');
$contentManager = ContentManager::getInstance();
$contentManager->prepare();
$contentManager->show();

//$pdf = new AuctionPdf(6);
//$pdf->arrayToHtml(array());
//$pdf->savePdf();
