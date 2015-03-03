<?php

class LoginController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        if (AuthState::init()->islogged())
        {
            $this->redirect("index/index");
        }

        $userModel = UserModel::model();
        $UseraddressModel = UseraddressModel::model();

        $userModel->unsetRule('username', 'unique');
        $userModel->unsetRule('email', 'required');
        $userModel->unsetRule('password_again', 'required');
        $models = array($userModel, $UseraddressModel);

        $form = new Form($models);

        if (InputRequest::IsPostRequest())
        {
            if ($form->validate())
            {
                try
                {
                    DB::getInstance()->getConnection()->beginTransaction();

                    $remember = (InputRequest::getPost('remember') == 'on') ? true : false;

                    $login = AuthState::init()->login(
                              InputRequest::getPostModel($userModel, 'username'), InputRequest::getPostModel($userModel, 'password'), $remember
                    );

                    if ($login)
                    {
                        DB::getInstance()->getConnection()->commit();
                        $this->redirect("index");
                    } else
                    {
                        $form->addError("User or password incorect");
                        DB::getInstance()->getConnection()->rollBack();
                    }
                } catch (Exception $ex)
                {
                    echo $ex->getMessage();
                    DB::getInstance()->getConnection()->rollBack();
                }
            }
        }

        $this->view->form = $form;
        $this->view->userModel = $userModel;
        $this->view->UseraddressModel = $UseraddressModel;

        $this->view->addactionPath = $this->getUrlByPath("login");

        $this->view->render('index/loginForm');
    }

}
