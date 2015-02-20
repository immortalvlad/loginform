<?php

class IndexController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {

        /* echo "<pre>";
          print_r($_COOKIE);
          print_r($_SESSION);
          echo "</pre>";
         */

        $langs = Language::init()->getlanguages();
        foreach ($langs as $lang)
        {
            $lang_arr["data"][$lang] = array(
                    "url" => "index",
                    "name" => App::app()->t($lang)
            );
        }


//        $res = UserModel::model()->selectById(1);
//        $res = UseraddressModel::model()->selectById(1);


        $this->view->langs = $lang_arr;
        $this->view->text = Language::init()->getLang();
        $this->view->render('index/loginForm');
    }

    public function addUserAction()
    {
        echo "add";
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
                "date_added" => date("Y-m-d H:i:s"),
                "status" => "1",
                "first_name" => "1",
                "last_name" => "1"
                  )
        );
        UseraddressModel::model()->insert(array(
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
//        echo "last insert id =" . $UserId;
    }

}
