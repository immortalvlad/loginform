<?php

class IndexController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $this->view->text = 'Hello World!';
        $this->view->render('index/index');
    }

    public function index2Action()
    {
        $this->view->text = 'Hello World!';
        $this->view->render('index/index');
    }

}