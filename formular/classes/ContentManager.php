<?php
use Controller\ErrorController;
use Controller\FooterController;
use Controller\HeadController;
use Controller\NavController;

class ContentManager
{
    private static $instance = null;
    private $headContent;
    private $navContent;
    private $contentContent;
    private $footerContent;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new ContentManager();
        }

        return self::$instance;
    }

    public function prepare()
    {
        $url = explode('/', $_SERVER['REQUEST_URI']);

        $controllers = array(
            'Controller\\FormController',
            'Controller\\LoginController'
            );


        foreach ($controllers as $controllerClass) {
            $action = $controllerClass::getAction($url);
            if ($action !== null) {
                $controller = new $controllerClass();
                $functionName = 'do' . ucfirst($action);
                $this->contentContent = $controller->$functionName($url);
                break;
            }
        }

        if (!isset($functionName)) {
            header('HTTP/1.1 404 Not Found');
            $controller = new ErrorController();
            $this->contentContent = $controller->doNotFound($url);
        }

        $head = new HeadController();
        $nav = new NavController();
        $footer = new FooterController();

        $this->headContent = $head->doShow();
        $this->navContent = $nav->doShow();
        $this->footerContent = $footer->doShow();

    }

    public function show()
    {

        echo $this->headContent;
        echo $this->navContent;
        echo $this->contentContent;
        echo $this->footerContent;
    }
}
