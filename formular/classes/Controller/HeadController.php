<?php
namespace Controller;


use Model\HeadModel;
use View\Template;

class HeadController extends AbstractController
{
    public function doShow()
    {
        $model = new HeadModel();
        $head = $model->getHead();
        $view = new Template('main/head');
        $view->assign('head', $head);
        return $view->render();
    }
}