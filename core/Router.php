<?php

/**
 * Router core class file
 */
class Router {

    /** 	@var string */
    private $_controller;

    /** 	@var string */
    private $_action;

    /** @var array */
    private static $_params = array();
    private static $_instance;

    /**
     * Class constructor
     */
    private function __construct()
    {

        $request = isset($_GET['url']) ? $_GET['url'] : '';


        $split = $this->getLangFormUrl($request);


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

    public function getController()
    {
        return $this->_controller;
    }

    public function getAction()
    {
        return $this->_action;
    }

    /**
     * Class init constructor
     * @param array $config
     * @return App
     */
    public static function init()
    {
        if (self::$_instance == null)
            self::$_instance = new self();
        return self::$_instance;
    }

    public function getLangFormUrl($url)
    {
        $split = explode('/', trim($url, '/'));

        $langs = Language::init()->getlanguages();

        if (in_array($split[0], $langs))
        {
            Language::init()->setLang($split[0]);

            array_shift($split);
        } else
        {
            Language::init()->setLang(Config::get("defaultLanguage"));
        }
        return $split;
    }

    /** 	 
     * Router
     * @param App $registry
     */
    public function route(App $registry)
    {
        $appDir = APP_PATH . DS . 'protect' . DS . 'controllers' . DS;
        $file = $this->_controller . 'Controller.php';

        if (is_file($appDir . $file))
        {
            $class = $this->_controller . 'Controller';
        } else
        {
            header("Location: /");
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

    /**
     * Return parametr value 
     * @param string $key
     * @return boolean
     */
    public static function getParamsByKey($key)
    {
        $params = self::getParams();

        if (array_key_exists($key, $params))
        {
            return $params[$key];
        } else
        {
            return false;
        }
    }

}
