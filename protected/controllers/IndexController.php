<?php

class IndexController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {

        echo "<pre>";
        print_r($_COOKIE);
        print_r($_SESSION);
        echo "</pre>";
        
        
        $this->view->langs = array();
        $langs = Language::init()->getlanguages();
        foreach ($langs as $lang)
        {
            $arr2["data"][$lang] = array(
                    "url" => "index",
                    "name" => App::app()->t($lang)
                    );
        }
        
        $this->view->langs = $arr2;
        $this->view->text = Language::init()->getLang();
        $this->view->render('index/index');
    }

}
