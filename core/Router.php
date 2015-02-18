<?php

/**
 * Router core class file
 *
 * @project ApPHP Framework
 * @author ApPHP <info@apphp.com>
 * @link http://www.apphpframework.com/
 * @copyright Copyright (c) 2012 ApPHP Framework
 * @license http://www.apphpframework.com/license/ 
 *
 * USAGE:
 * ----------
 * 1st way - URL	: http://localhost/site/index.php?url=page/contact&param1=aaa&param2=bbb&param3=ccc
 *           CONFIG : 'urlFormat'=>'get' (default)
 * 			 CALL	: $controller->$action();
 * 			 GET	: A::app()->getRequest()->getQuery('param1');
 * 			 FILTER	: manually in code
 * 2st way - URL	: http://localhost/site/page/contact?param1=aaa&param2=bbb&param3=ccc
 *           CONFIG	: 'urlFormat'=>'get' (default)
 * 			 CALL	: $controller->$action();
 *           GET	: A::app()->getRequest()->getQuery('param1');
 *           FILTER	: manually in code
 * 3st way - URL	: http://localhost/site/page/contact/param1/aaa/param2/bbb/param3/ccc
 *           CONFIG	: 'urlFormat'=>'path' (default)
 *           CALL	: $controller->$action($param1, $param2, $param3);
 *           GET	: actionName($param1 = '', $param2 = '', $param3 = '')
 *           FILTER	: manually in code
 * 4st way - URL	: according to redirection rule
 * 				  		- simple redirection rule: * 				    
 *                  	  'param1/param2/../'=>'paramA/param1/paramB/param2/../',
 *           CONFIG	: 'urlFormat'=>'shortPath' (default)
 *           CALL	: $controller->$action($param1, $param2, $param3);
 *           GET	: actionName($param1 = '', $param2 = '', $param3 = '')
 *           FILTER	: automatically according to define type (not implemented yet)
 * 
 *           
 * 
 *
 * PUBLIC:					PROTECTED:					PRIVATE:		
 * ----------               ----------                  ----------
 * __construct
 * route
 * 
 * STATIC:
 * ---------------------------------------------------------------
 * getParams
 * 
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
        $urlFormat = Config::get('urlManager.urlFormat');
        $rules = Config::get('urlManager.rules');
        $request = isset($_GET['url']) ? $_GET['url'] : '';

        $standardCheck = true;

        // check if there are special URL rules 
        if ($urlFormat == 'shortPath')
        {
            foreach ($rules as $rule => $val)
            {
                // direct rule compare
                if ($rule === $request)
                {
                    $request = $val;
                    break;
                }
            }

            // if not found - use a standard way
            $urlFormat = '';
        }

        $lang = array(
                "ru", "en"
        );
        if ($standardCheck)
        {
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
        } else
        {
            $comDir = APP_PATH . DS . 'protected' . DS . $registry->mapAppModule($this->_controller) . 'controllers' . DS;
            if (is_file($comDir . $file))
            {
                $class = $this->_controller . 'Controller';
            } else
            {
                $class = 'ErrorController';
            }
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
