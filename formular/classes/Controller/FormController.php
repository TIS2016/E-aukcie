<?php

namespace Controller;


use Model\AuctionFkModel;
use Model\FormModel;
use Model\ProjectModel;
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
            if (isset($_SESSION['admin']) && !$_SESSION['admin'] && !isset($urlParts[FIRST_URL_INDEX + 1])) {
                return null;
            }
            if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
                if (isset($urlParts[FIRST_URL_INDEX + 1]) && $urlParts[FIRST_URL_INDEX + 1] != '') {
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
        $formModel = new FormModel();
        $projectModel = new ProjectModel();
        $auctionFkModel = new AuctionFkModel();
        $message = null;

        if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_POST['sendData'])) {
            $lastId = $formModel->saveAdminData($_POST);
            $message = array(
                'message' => 'Aukcia bola pridaná!',
                'url' => $lastId
            );
        }

        if (isset($_SESSION['admin']) && !$_SESSION['admin'] && isset($_POST['sendData'])) {
            $formModel->saveClientData($_POST);
        }

        $data = $formModel->getFormData($urlParts);
        $projects = $projectModel->getProjects();
        $currencies = $auctionFkModel->getCurrencies();
        $types = $auctionFkModel->getTypes();
        $statuses = $auctionFkModel->getStatuses();

        $view = new Template('form/form');

        $view->assign('data', $data);
        $view->assign('projects', $projects);
        $view->assign('currencies', $currencies);
        $view->assign('types', $types);
        $view->assign('statuses', $statuses);
        $view->assign('message', $message);

        return $view->render();
    }

}