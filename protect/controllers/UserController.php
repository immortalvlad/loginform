<?php

class UserController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function profileAction()
    {
        $userData = AuthState::init()->getData();
        $usermodel = UserModel::model();
        $this->view->usermodel = $usermodel;
        $this->view->userdata = $userData;

        $this->view->render('index/userProfile');
    }

    public function changepasswordAction()
    {
        if (!AuthState::init()->islogged())
        {
            $this->redirect("index/index");
        }
        $userModel = UserModel::model();

        $userModel->addRule('new_password', array(
                'required' => true,
                'min' => 6,
                'max' => 20
                  ), 'New password');

        $userModel->addRule('new_password_again', array(
                'required' => true,
                'min' => 6,
                'max' => 20,
                'matches' => 'new_password',
                  ), 'New password Again');

        $userModel->setAttributeLabel('password', 'Current password');
        $userModel->unsetRule('email', 'required');
        $userModel->unsetRule('username', 'required');
        $userModel->unsetRule('password_again', 'required');

        $form = new Form($userModel);

        if (InputRequest::init()->IsPostRequest())
        {
            if ($form->validate())
            {
                $user = AuthState::init()->getData();
                $inputPassword = InputRequest::getPostModel($userModel, 'password');
                if ($user['password'] !== Hash::make($inputPassword, $user['salt']))
                {
                    $form->addError('Пароль не совпадает с текущим');
                } else
                {
                    $salt = Hash::salt();
                    $password = Hash::make(InputRequest::getPostModel($userModel, 'new_password'), $salt);
                    $update = $userModel->update($user[$userModel->getPK()], array(
                            'password' => $password,
                            'salt' => $salt
                    ));
                    if ($update)
                    {
                        Message::show('update', 'Passs was be  successful updated');
                        $this->redirect("index");
                    } else
                    {
                        $form->addError('Пароль не был обновлен');
                    }
                }
            }
        }

        $this->view->addactionPath = $this->getUrlByPath("user/changepassword");
        $this->view->form = $form;
        $this->view->userModel = $userModel;
        $this->view->render('index/changepasswordForm');
    }

    public function forgotpasswordAction()
    {
        if (AuthState::init()->islogged())
        {
            $this->redirect('index');
        }
        $userModel = SimpleModel::model();
        $userModel->addRule('email', array(
                "required" => true,
                "type" => 'email',
                  ), 'Email to ');
        $form = new Form($userModel);

        if (InputRequest::IsPostRequest())
        {
            if ($form->validate())
            {
                $key = Hash::unique();
                $emailInput = InputRequest::getPostModel($userModel, 'email');
                $RowUser = UserModel::model()->getPkByField('email', $emailInput);
                if ($RowUser)
                {
                    $UserrecoverModel = UserrecoverModel::model();
                    $id = $RowUser[0][UserModel::model()->getPK()];
                    if ($RowUserrecover = $UserrecoverModel->getPkByField('user_entity_id', $id))
                    {
                        $UserrecoverModel->update($RowUserrecover[0][$UserrecoverModel->getPK()], array(
                                "recover_key" => $key,
                        ));
                    } else
                    {
                        $UserrecoverModel->insert(array(
                                "user_entity_id" => $id,
                                "recover_key" => $key,
                        ));
                    }
                    $host = Config::get('host');
                    $message = "Для востановления пероля перейдите по следующей ссылке:<br>";
                    $message .= "<a href='{$host}user/recoverpassword/key/{$key}'>Перейти для востановления</a>";
                    $send = Mail::send($emailInput, 'Recover password', $message);
                    if ($send)
                    {
                        Message::show('update', 'на указанный email был выслан код');
                        $this->redirect('index');
                    } else
                    {
                        $form->addError('Не удалось отправить почту');
                    }
                } else
                {
                    $form->addError('Email не найден');
                }
            }
        }

        $this->view->form = $form;
        $this->view->userModel = $userModel;
        $this->view->addactionPath = $this->getUrlByPath("user/forgotpassword");
        $this->view->render('index/forgotpasswordForm');
    }

    public function recoverpasswordAction()
    {
        if (AuthState::init()->islogged())
        {
            $this->redirect('index');
        }
        $key = Router::getParamsByKey('key') ? Router::getParamsByKey('key') : InputRequest::getPost('key');
        $UserrecoverModel = UserrecoverModel::model();
        $rowRecover = $UserrecoverModel->find('recover_key', $key);
        if (empty($rowRecover))
        {
            die("");
        }

        $userModel = SimpleModel::model();
        $userModel->addRule('new_password', array(
                'required' => true,
                'min' => 6,
                'max' => 20
                  ), 'New password');

        $userModel->addRule('new_password_again', array(
                'required' => true,
                'min' => 6,
                'max' => 20,
                'matches' => 'new_password',
                  ), 'New password Again');
        $form = new Form($userModel);

        if (InputRequest::IsPostRequest())
        {
            if ($form->validate())
            {
                $passwordInput = InputRequest::getPostModel($userModel, 'new_password');
                $salt = Hash::salt();
                $password = Hash::make($passwordInput, $salt);
                $is_upddate = UserModel::model()->update($rowRecover[0]['user_entity_id'], array(
                        "password" => $password,
                        "salt" => $salt,
                ));
                if ($is_upddate)
                {
                    $UserrecoverModel->update($rowRecover[0]['user_recover_id'], array(
                            "recover_key" => null,
                    ));
                    Message::show('update', 'Пароль изменен на новый попробуйте войти');
                    $this->redirect('index');
                }
            }
        }

        $this->view->form = $form;
        $this->view->userModel = $userModel;
        $this->view->keyval = $key;
        $this->view->addactionPath = $this->getUrlByPath("user/recoverpassword");
        $this->view->render('index/recoverpasswordForm');
    }

    public function useractivateAction()
    {
        if (AuthState::init()->islogged())
        {
            $this->redirect('index');
        }
        $key = Router::getParamsByKey('key');
        $UserrecoverModel = UserrecoverModel::model();
        $rowRecover = $UserrecoverModel->find('activation_key', $key);
        if (empty($rowRecover))
        {
            die("");
        }

        $is_update = UserModel::model()->update($rowRecover[0]["user_entity_id"], array(
                "status" => 1,
        ));
        if ($is_update)
        {
            Message::show('update', 'Ваш акаунт был активирован');
            $this->redirect('index');
        }

        $this->view->render('index/useractivateForm');
    }

}
