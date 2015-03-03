<?php

class IndexController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {

        $this->view->user = AuthState::init()->getData();
//        Helper::PR(AuthState::init()->getData());
//        Helper::PR($_SESSION);
        if (AuthState::init()->islogged())
        {
            $this->view->render('index/index');
        } else
        {
            $this->view->render('index/notLogin');
        }
    }

    public function logoutAction()
    {
        AuthState::init()->logout();
        $this->redirect("index");
    }

    public function registerAction()
    {
        $userModel = UserModel::model();
        $userModel->addRule('captcha', array(
                'required' => true,
                'type' => 'captcha',
                  ), 'Captcha');
        
        $UserpictureModel = UserpictureModel::model();
        
        $UserpictureModel->addRule('image', array(
                'type'=>'image'
        ),'Avatar');
        
        $UseraddressModel = UseraddressModel::model();
        $models = array($userModel,$UserpictureModel, $UseraddressModel);
        $form = new Form($models);

        if (InputRequest::IsPostRequest())
        {
            Helper::PR($_FILES);
            if ($form->validate())
            {
                try
                {
                    DB::getInstance()->getConnection()->beginTransaction();

                    $id = $this->userInsert($userModel);

                    if (isset($id))
                    {
                        $this->insertActivationKey($id);

                        DB::getInstance()->getConnection()->commit();

                        $this->sendActivationMail(InputRequest::getPostModel($userModel, 'email'));
                    } else
                    {
                        DB::getInstance()->getConnection()->rollBack();
                    }
                } catch (Exception $ex)
                {
                    echo $ex->getMessage();
                    DB::getInstance()->getConnection()->rollBack();
                }
            }
        }
        $countries = CountryModel::model()->selectAll();
//        Helper::PR($country);
        $this->view->countries = $countries;
        $this->view->form = $form;
        $this->view->userModel = $userModel;
        $this->view->UserpictureModel = $UserpictureModel;
        $this->view->UseraddressModel = $UseraddressModel;

        $this->view->addactionPath = $this->getUrlByPath("index/register");
        $this->view->render('index/registerForm');
    }

    public function getCitiesAction()
    {
        if ($id = Router::getParamsByKey("id"))
        {

            header('Content-Type: application/json');

// now output our json object
//        echo '{"name":"darian","lastname":"brown","age":87,"adress":{"21 somewhere street","my city","Australia"}}';
//        header('Content-type: application/json');
            $cities = CityModel::model()->find('CountryCode', $id);
            $result = json_encode($cities);
//        Helper::PR($result);
            echo $result;
        }
//        return  $result;
    }

    private function insertActivationKey($id)
    {
        $rowrecovery = UserrecoverModel::model()->getPkByField('user_entity_id', $id);
        $hash = Hash::unique();
        Session::init()->set('activation_hash', $hash);
        if ($rowrecovery)
        {
            UserrecoverModel::model()->update($rowrecovery[0][UserrecoverModel::model()->getPK()], array(
                    "activation_key" => $hash
            ));
        } else
        {
            UserrecoverModel::model()->insert(array(
                    "user_entity_id" => $id,
                    "activation_key" => $hash,
            ));
        }
    }

    private function userInsert($userModel)
    {
        $salt = Hash::salt();
        $password = Hash::make(InputRequest::getPostModel($userModel, 'password'), $salt);
        $id = UserModel::model()->insert(array(
                'email' => InputRequest::getPostModel($userModel, 'email'),
                'username' => InputRequest::getPostModel($userModel, 'username'),
                'password' => $password,
                'date_added' => date("Y-m-d H:i:s"),
                'status' => 0,
                'first_name' => InputRequest::getPostModel($userModel, 'first_name'),
                'last_name' => InputRequest::getPostModel($userModel, 'last_name'),
                'salt' => $salt,
        ));
        return $id;
    }

    public function delUserAction()
    {
        if ($id = Router::getParamsByKey("id"))
        {
            UserModel::model()->deleteById("user_entity_id", $id);
            UseraddressModel::model()->deleteById("user_entity_id", $id);
            UserpictureModel::model()->deleteById("user_entity_id", $id);
        }
    }

    public function sendActivationMail($emailTo)
    {
        $host = Config::get('host');
        $key = Session::init()->get('activation_hash');

        Session::init()->deleteSession('activation_hash');
        $message = "Для активации акаунта перейдите по следующей ссылке:<br>";
        $message .= "<a href='{$host}user/useractivate/key/{$key}'>Перейти для активации</a>";
        $send = Mail::send($emailTo, 'Recover password', $message);
        return $send;
    }

}
