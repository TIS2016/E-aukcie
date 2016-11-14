<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 2016.11.10.
 * Time: 22:38
 */

namespace Controller;


use Model\NavModel;
use View\Template;

class NavController
{
    public function doShow()
    {
        $model = new NavModel();
        $head = $model->getNav();
        $view = new Template('components/nav');
        $view->assign('head', $head);
        return $view->render();
    }
}