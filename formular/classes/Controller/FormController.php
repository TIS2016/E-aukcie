<?php

namespace Controller;


use Model\FormModel;
use View\Template;

class FormController extends AbstractController
{
    public static function getAction($urlParts)
    {
        return 'show';
    }

    public function doShow($urlParts){
        $model = new FormModel();
        $head = $model->getForm();
        $view = new Template('form/form');
        $view->assign('head', $head);
        return $view->render();
    }

}