<?php

namespace Controller;


use Model\LoginModel;
use View\Template;

class LoginController extends AbstractController
{
    public static function getAction($urlParts)
    {
        if ($urlParts[FIRST_URL_INDEX] == 'login') {
            if (isset($_POST['loginSubmit'])) {
            }
            return 'show';
        }
        return null;
    }

    public function doShow($urlParts)
    {
        $errormsg = null;
        if (isset($_POST['loginSubmit']) && isset($_POST['loginName']) && isset($_POST['loginPassword'])) {
            $model = new LoginModel();
            $data = $model->doLogin($_POST['loginName'], $_POST['loginPassword']);
            if ($data == null) {
                $errormsg = array('message' => 'Wrong Login Name or Password!');
            } else {
                $_SESSION['logged'] = true;
                $_SESSION['admin'] = ($data['fk_role'] == 'ADMIN') ? true : false;
                header('Location:/form');
                exit(0);
            }
        }
        $view = new Template('login/login');
        $view->assign('message', $errormsg);
        return $view->render();
    }
}