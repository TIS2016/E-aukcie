<?php

namespace Controller;


use Model\FormModel;
use View\Template;

class FormController extends AbstractController
{
    /**
     * @param $urlParts
     * @return string
     */
    public static function getAction($urlParts)
    {
        if ($urlParts[FIRST_URL_INDEX] == 'form') {
            if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
                if (isset($urlParts[FIRST_URL_INDEX + 1])) {
                    $_SESSION['auctionID'] = $urlParts[FIRST_URL_INDEX + 1];
                }
                header("Location:" . '/login');
                exit(0);
            }
            return 'show';
        }
        return null;
    }

    public function doShow($urlParts)
    {
        $model = new FormModel();
        if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_POST['sendData'])) {
            $model->saveAdminData($_POST);
        }
        $data = $model->getFormData($urlParts);
        $view = new Template('form/form');
        $view->assign('data', $data);
        return $view->render();
    }

}