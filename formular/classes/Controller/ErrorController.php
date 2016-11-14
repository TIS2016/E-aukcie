<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 2016.11.10.
 * Time: 21:32
 */

namespace Controller;


use View\Template;

class ErrorController extends AbstractController
{
    public function doNotFound($urlParts) {
        $view = new Template('error/notFound');
        return $view->render();
    }
}