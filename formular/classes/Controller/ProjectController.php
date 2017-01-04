<?php
namespace Controller;


use Model\ProjectFkModel;
use Model\ProjectModel;
use View\Template;

class ProjectController extends AbstractController
{
    public static function getAction($urlParts)
    {
        if ($urlParts[FIRST_URL_INDEX] == 'newProject') {
            if (isset($_SESSION['admin']) && $_SESSION['admin']) {
                return 'show';
            }
        }
        return null;
    }

    public function doShow($urlParts)
    {
        $projectFkModel = new ProjectFkModel();
        $model = new ProjectModel();
        if(isset($_POST['sendProjectData'])){
            $model->saveProject($_POST);
            header('Location:/form');
            exit(0);
        }
        $clients = $projectFkModel->getClients();
        $owners = $projectFkModel->getOwners();
        $view = new Template('newProject/form');
        $view->assign('clients', $clients);
        $view->assign('owners', $owners);
        return $view->render();
    }
}