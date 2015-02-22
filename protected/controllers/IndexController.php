<?php

class IndexController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $langs = Language::init()->getlanguages();
        foreach ($langs as $lang)
        {
            $lang_arr["data"][$lang] = array(
                    "url" => $this->Url(),
                    "name" => App::app()->t($lang)
            );
        }

        $this->view->langs = $lang_arr;


        echo "<pre>";
//        print_r($attributes);
//        print_r($_COOKIE);
//        print_r($_SESSION);
        echo "</pre>";
        $this->view->attributes = $this->combineAttributes();

        $this->view->adctionPath = $this->getUrlByPath("index/add");

        $this->view->text = Language::init()->getLang();

        $this->view->render('index/loginForm');
        $this->view->render('index/index');
    }

    private function combineAttributes()
    {
        $attributes = array();
        $attributes +=array_merge(UserModel::model()->attributeLabels());
        $attributes +=array_merge(UseraddressModel::model()->attributeLabels());
        $attributes +=array_merge(UserphoneModel::model()->attributeLabels());
        $attributes +=array_merge(UserpictureModel::model()->attributeLabels());
        return $attributes;
    }

    public function addAction()
    {
        //echo "add";
        $this->redirect("index");
        $this->indexAction();

        exit;
    }

    public function delUserAction()
    {
        if ($id = Router::getParamsByKey("id"))
        {
            UserModel::model()->deleteById("user_entity_id", $id);
            UseraddressModel::model()->deleteById("user_entity_id", $id);
            UserphoneModel::model()->deleteById("user_entity_id", $id);
            UserpictureModel::model()->deleteById("user_entity_id", $id);
        }
    }

    public function testAddAction()
    {
        $userId = UserModel::model()->insert(array(
                "email" => "gggggg",
                'password' => "fdsfsdfsdfdfd",
                "date_added" => date("Y-m-d H:i:s"),
                "status" => "1",
                "first_name" => "1",
                "last_name" => "1"
                  )
        );
      /*  UseraddressModel::model()->insert(array(
                "user_entity_id" => $userId,
                "country_id" => "2",
                "city_id" => "1"
                  )
        );
        UserphoneModel::model()->insert(array(
                "user_entity_id" => $userId,
                "value" => "2"
                  )
        );
        UserpictureModel::model()->insert(array(
                "user_entity_id" => $userId,
                "path" => "some/fgfgf.jpg",
                "type" => "jpg"
                  )
        );
        $this->redirect("index");*/
//        echo "last insert id =" . $UserId;
    }

}
