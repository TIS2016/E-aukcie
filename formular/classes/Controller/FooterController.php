<?php
/**
 * Created by PhpStorm.
 * User: Tomi
 * Date: 2016.11.10.
 * Time: 21:23
 */

namespace Controller;


use Model\FooterModel;
use View\Template;

class FooterController extends AbstractController
{
    public function doShow()
    {
        $model = new FooterModel();
        $head = $model->getFooter();
        $view = new Template('main/footer');
        $view->assign('head', $head);
        return $view->render();
    }
}