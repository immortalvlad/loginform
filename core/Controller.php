<?php

/**
 * Controller base class file
 *
 * @project ApPHP Framework
 * @author ApPHP <info@apphp.com>
 * @link http://www.apphpframework.com/
 * @copyright Copyright (c) 2012 ApPHP Framework
 * @license http://www.apphpframework.com/license/ 
 * 
 * PUBLIC:					PROTECTED:					PRIVATE:		
 * ----------               ----------                  ----------
 * __construct                                          getCalledClass
 * testAction
 * errorAction
 * redirect
 * 
 * STATIC:
 * ---------------------------------------------------------------
 *
 */
class Controller {

    /** @var View */
    protected $view;

    /**
     * Class constructor
     * @return void
     */
    function __construct()
    {
        $this->view = App::app()->view;
    }

    /**
     * Renders test action
     */
    public function testAction()
    {
        if (APPHP_MODE == 'test')
        {
            $controller = $this->getCalledClass();
            if ($controller . '/index' == $this->view->render($controller . '/index'))
            {
                return true;
            } else
            {
                return false;
            }
        } else
        {
            $this->redirect('error/index');
        }
    }

    /**
     * Renders error 404 view
     */
    public function errorAction()
    {
        $this->view->header = 'Error 404';

        $this->view->render('error/index');
    }

    public function getUrlByPath($action)
    {
        $lang = Language::init()->getLang();
        return "/" . $lang . "/" . $action;
    }

    public function Url()
    {
        return $this->view->getController() . "/" . $this->view->getAction();
    }

    /**
     * Redirects to another controller
     * Parameter may consist from 2 parts: controller/action or just controller name
     * @param string $path
     */
    public function redirect($path)
    {

        header('location: /' . Language::init()->getLang() . "/" . $path);
        exit;
    }

}
