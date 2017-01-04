<?php

namespace Controller;


use DataObject\AdminFromData;
use Model\AuctionFileModel;
use Model\AuctionFkModel;
use Model\FooterModel;
use Model\FormModel;
use Model\ModelException;
use Model\ProjectModel;
use PdfGen\PDF;
use View\Template;

class FormController extends AbstractController
{
    /**
     * @param $urlParts
     * @return string
     */
    public static function getAction($urlParts)
    {
//        print_r($_SESSION);
        if ($urlParts[FIRST_URL_INDEX] == 'form') {
            if (isset($urlParts[FIRST_URL_INDEX + 1]) && $urlParts[FIRST_URL_INDEX + 1] == 'pdf') return 'pdf';
            if (isset($_SESSION['adminFromData']) && !isset($_POST['cancelFormData'])) return 'showCheck';
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

    public function doPdf($urlParts)
    {
//        echo 'asd';
        $pdf = new PDF();
        $pdf->dataToPdf(unserialize($_SESSION['adminFromData']['data']));
        $pdf->Output();
    }

    public function doShowCheck($urlParts)
    {
        $model = new FormModel();
        if (isset($_POST['cancelFormData'])) {
            try {
                unlink('auction_files\\tmpFiles\\' . $_SESSION['adminFromData']['file']);
            } catch (\Exception $e) {
                print_r($e);
            }
//            unset($_SESSION['adminFromData']);
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
        if (isset($_POST['saveMails'])) {
            $model->saveAdminData(unserialize($_SESSION['adminFromData']['data']), $_SESSION['adminFromData']['file']);
            $model->createUsers($_POST['emails']);
            unset($_SESSION['adminFromData']);
            header('Location: ' . $_SERVER['REQUEST_URI']);
        }
        $auctionFkModel = new AuctionFkModel();
        $projectModel = new ProjectModel();
        /**
         * @var $adminFormData AdminFromData
         */
        $adminFormData = unserialize($_SESSION['adminFromData']['data']);
        $project = $projectModel->getProjectName($adminFormData->getProject());
        $currency = $auctionFkModel->getCurrency($adminFormData->getCurrency());
        $type = $auctionFkModel->getType($adminFormData->getType());

        $view = new Template('form/check');
        $view->assign('data', $adminFormData);
        $view->assign('projectName', $project->getName());
        $view->assign('currency', $currency);
        $view->assign('type', $type);
        return $view->render();
    }

    /**
     * @param $urlParts
     * @return string
     */
    public function doShow($urlParts)
    {
        print_r($_SESSION);
        $formModel = new FormModel();
        $projectModel = new ProjectModel();
        $auctionFkModel = new AuctionFkModel();
        $auctionFileModel = new AuctionFileModel();

        $message = null;
        $clientMessage = null;
        $errorMessage = null;
        $files = null;
        $showUserForm = null;

        if (isset($_SESSION['admin']) && $_SESSION['admin']) {
            $showUserForm = false;
        } else {
            $showUserForm = true;
        }

        if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($urlParts[FIRST_URL_INDEX + 1])) {
            try {
                $files = $auctionFileModel->getAllFiles($urlParts[FIRST_URL_INDEX + 1]);
            } catch (\Exception $e) {
            }
        }
        if (isset($_SESSION['admin']) && !$_SESSION['admin'] && isset($urlParts[FIRST_URL_INDEX + 1])) {
            try {
                $files = $auctionFileModel->getAllFiles($urlParts[FIRST_URL_INDEX + 1], $_SESSION['name']);
            } catch (\Exception $e) {
            }
        }


        if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_POST['sendData'])) {
            try {
                $formModel->saveAdminDataToSession($_POST, $_FILES['document']);
                header('Location: ' . $_SERVER['REQUEST_URI']);
                exit(0);
//                $lastId = $formModel->saveAdminData($_POST, $_FILES);
//                $message = array(
//                    'message' => 'Aukcia bola pridaná!',
//                    'url' => $lastId
//                );
            } catch (ModelException $e) {
                $errorMessage = array(
                    'type' => 'Error: ',
                    'message' => $e->getMessage()
                );
            }
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
        } elseif (isset($_SESSION['adminFromData'])) {
            $data = unserialize($_SESSION['adminFromData']['data']);
            unset($_SESSION['adminFromData']);
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
        $view->assign('showUserForm', $showUserForm);

        return $view->render();
    }

}