<?php

namespace Controller;


use Model\AuctionFileModel;
use Model\AuctionFkModel;
use Model\FormModel;
use Model\ModelException;
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
        $auctionFileModel = new AuctionFileModel();

        $message = null;
        $clientMessage = null;
        $errorMessage = null;
        $files = null;

        if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($urlParts[FIRST_URL_INDEX+1])) {
            try {
                $files = $auctionFileModel->getAllFiles($urlParts[FIRST_URL_INDEX + 1]);
            } catch (\Exception $e) {
            }
        }
        if (isset($_SESSION['admin']) && !$_SESSION['admin'] && isset($urlParts[FIRST_URL_INDEX+1])) {
            try {
                $files = $auctionFileModel->getAllFiles($urlParts[FIRST_URL_INDEX + 1], $_SESSION['name']);
            } catch (\Exception $e) {
            }
        }


        try {
            if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_POST['sendData'])) {
                $lastId = $formModel->saveAdminData($_POST, $_FILES);
                $message = array(
                    'message' => 'Aukcia bola pridaná!',
                    'url' => $lastId
                );
            }
        } catch (ModelException $e) {
            $errorMessage = array(
                'type' => 'Error: ',
                'message' => $e->getMessage()
            );
        }

        if (isset($_SESSION['admin']) && !$_SESSION['admin'] && isset($_POST['sendData'])) {

            try {
                $formModel->saveClientData($_POST, $_FILES, $urlParts[FIRST_URL_INDEX + 1]);
                $clientMessage = array(
                    'message' => 'Vaše údaje sme úspešne uložily'
                );
            } catch (ModelException $e) {
                $errorMessage = array(
                    'type' => 'Error; ',
                    'message' => $e->getMessage()
                );
            }
        }

        $data = $formModel->getFormData($urlParts);
        if (isset($_POST['sendData']) && (!isset($urlParts[FIRST_URL_INDEX + 1]) || $urlParts[FIRST_URL_INDEX + 1] == '')) {
            $data = $formModel->getadminDataFromPost($_POST);
        }
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
        $view->assign('clientMessage', $clientMessage);
        $view->assign('errorMessage', $errorMessage);
        $view->assign('files', $files);

        return $view->render();
    }

}