<?php

class CaptchaController extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $capthaOBJ = new Captcha();
        $capthaOBJ->Generate($width = 100, $height = 30, $length = 5); 
    }

}
