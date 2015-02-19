<?php

/**
 * Router core class file
 */
class Router {

    /** 	@var string */
    private $_path;

    /** 	@var string */
    private $_controller;

    /** 	@var string */
    private $_action;

    /** 	@var string */
    private $_module;

    /** @var array */
    private static $_params = array();

    /**
     * Class constructor
     */
    public function __construct()
    {
        $request = isset($_GET['url']) ? $_GET['url'] : '';
        echo App::app()->getLanguage()->getLang();
        echo "<br>";
        App::app()->getLanguage()->setLang("en");
        echo App::app()->getLanguage()->getLang();
        echo "<br>";
        echo Session::init()->getSessionName();
        echo "<br>";
        echo Session::init()->getSessionId();
        echo "<br>";
        echo Session::init()->set("some", "123");
        echo Session::init()->get("some");
        echo "<br>";
        $lang = array(
                "ru", "en"
        );

        $split = explode('/', trim($request, '/'));

        if (in_array($split[0], $lang))
        {
            array_shift($split);
        }
        if ($split)
        {
            foreach ($split as $index => $part)
            {
                if (!$this->_controller)
                {
                    $this->_controller = ucfirst($part);
                } else if (!$this->_action)
                {
                    $this->_action = $part;
                } else
                {
                    if (!self::$_params || end(self::$_params) !== null)
                    {
                        self::$_params[$part] = null;
                    } else
                    {
                        $arrayArg = array_keys(self::$_params);
                        self::$_params[end($arrayArg)] = $part;
                    }
                }
            }
        }

        if (!$this->_controller)
        {
            $defaultController = Config::get('defaultController');
            $this->_controller = !empty($defaultController) ? Filter::sanitize('alphanumeric', $defaultController) : 'Index';
        }
        if (!$this->_action)
        {
            $defaultAction = Config::get('defaultAction');
            $this->_action = !empty($defaultAction) ? Filter::sanitize('alphanumeric', $defaultAction) : 'index';
        }
    }

    /** 	 
     * Router
     * @param App $registry
     */
    public function route(App $registry)
    {
        $appDir = APP_PATH . DS . 'protected' . DS . 'controllers' . DS;
        $file = $this->_controller . 'Controller.php';

        if (is_file($appDir . $file))
        {
            $class = $this->_controller . 'Controller';
        }
        $registry->view->setController($this->_controller);
        $controller = new $class();

        if (is_callable(array($controller, $this->_action . 'Action')))
        {
            $action = $this->_action . 'Action';
        } else if ($class != 'ErrorController')
        {
            $action = 'errorAction';
        } else
        {
            $action = 'indexAction';
        }

        $registry->view->setAction($this->_action);
        // call controller::action + pass parameters
        call_user_func_array(array($controller, $action), $this->getParams());
    }

    /**
     * Get array of parameters
     * @return array
     */
    public static function getParams()
    {
        return self::$_params;
    }

}
