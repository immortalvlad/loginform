<?php

/**
 * Apphp bootstrap file
 *
 * @project ApPHP Framework
 * @author ApPHP <info@apphp.com>
 * @link http://www.apphpframework.com/
 * @copyright Copyright (c) 2012 ApPHP Framework
 * @license http://www.apphpframework.com/license/
 *
 * PUBLIC:					PROTECTED:					PRIVATE:		
 * ----------               ----------                  ----------
 * __construct              registerCoreComponents      autoload
 * run                      onBeginRequest
 * getVersion
 * powered
 * setComponent
 * getComponent
 * getRequest
 * getSession
 * setTimeZone
 * getTimeZone
 * attachEventHandler
 * detachEventHandler
 * hasEvent
 * hasEventHandler
 * raiseEvent
 * mapAppModule
 * 
 * STATIC:
 * ---------------------------------------------------------------
 * init
 * app
 * 
 */
class App {

    /** 	@var object View */
    public $view;


    /** @var object */
    private static $_instance;

    /** @var array */
    private static $_classMap = array(
            'Controller' => 'controllers',
            'Model' => 'models',
    );

    /** @var array */
    private static $_coreClasses = array(
            'Config' => 'collections/Config.php',
            'View' => 'core/View.php',
            'Router' => 'core/Router.php',
            'Filter' => 'helpers/Filter.php',
            'Controller' => 'core/Controller.php',
    );

    /** @var array */
    private static $_coreComponents = array(
              /* 	'session' 		=> 'HttpSession',
                'request' 		=> 'HttpRequest',
                'clientScript'  => 'ClientScript', */
    );

    /** @var array */
    private $_components = array();

    /** @var array */
    private $_events;

    /** @var boolean */
    private $_setup = false;

    /**
     * Class constructor
     * @param array $configDir
     */
    public function __construct($configDir)
    {
        spl_autoload_register(array($this, 'autoload'));

        $configMain = $configDir . 'main.php';
        $configDb = $configDir . 'db.php';

        if (is_string($configMain) && is_string($configDb))
        {

            $arrConfig = require($configMain);
            // check if db configuration file exists and marge it with a main config file
            if (file_exists($configDb))
            {
                $arrDbConfig = require($configDb);
                $arrConfig = array_merge($arrConfig, $arrDbConfig);
            }
            // save configuration array in config class
            Config::set($arrConfig);
        }
    }

    /**
     * Runs application
     */
    public function run()
    {
        // specify error settings
        if (APPHP_MODE == 'debug' || APPHP_MODE == 'test')
        {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else
        {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', APP_PATH . DS . 'protected' . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
        }
    
        // register framework core components
        $this->registerCoreComponents();      

        // load view
        $this->view = new View();
        $this->view->setTemplate(Config::get('defaultTemplate'));

        $router = new Router();
        $router->route($this);
    }

    /**
     * Class init constructor
     * @param array $config
     * @return Apphp
     */
    public static function init($config = array())
    {
        if (self::$_instance == null)
            self::$_instance = new self($config);
        return self::$_instance;
    }

    /**
     * Returns A object
     * @param array $config
     * @return Apphp
     */
    public static function app()
    {
        return self::$_instance;
    }



    /**
     * Autoloader
     * @param str $className
     * @return void
     */
    private function autoload($className)
    {
        if (isset(self::$_coreClasses[$className]))
        {
            // use include so the error PHP file may appear
            include(dirname(__FILE__) . DS . self::$_coreClasses[$className]);
        } else
        {
            $classNameItems = preg_split('/(?=[A-Z])/', $className);
            print_r($classNameItems);
            // $classNameItems[0] - 
            // $classNameItems[1] - ClassName
            // $classNameItems[2] - Type (Controller, Model etc..)
            if (isset($classNameItems[2]) && isset(self::$_classMap[$classNameItems[2]]))
            {
                 $classCoreDir = APP_PATH . DS . 'protected' . DS . self::$_classMap[$classNameItems[2]];
                
                 $classFile = $classCoreDir . DS . $className . '.php';
                if (is_file($classFile))
                {
                    
                    require_once $classFile;
                } else
                {                  
                    $classModuleDir = APP_PATH . DS . 'protected' . DS . $this->mapAppModule($classNameItems[1]) . self::$_classMap[$classNameItems[2]];
                    $classFile = $classModuleDir . DS . $className . '.php';
                    require_once $classFile;
                }
            }
        }
    }

    /**
     * Puts a component under the management of the application
     * @param string $id
     * @param class $component 
     */
    public function setComponent($id, $component)
    {
        if ($component === null)
        {
            unset($this->_components[$id]);
        } else
        {
            // for PHP_VERSION >= 5.3.0 you may use
            // $this->_components[$id] = $component::init();
            $this->_components[$id] = call_user_func_array($component . '::init', array());
        }
    }

    /**
     * Returns the application component
     * @param string $id
     */
    public function getComponent($id)
    {
        return (isset($this->_components[$id])) ? $this->_components[$id] : null;
    }

    /**
     * Returns the client script component
     * @return ClientScript component
     */
    public function getClientScript()
    {
        return $this->getComponent('clientScript');
    }

    /**
     * Returns the request component
     * @return HttpRequest component
     */
    public function getRequest()
    {
        return $this->getComponent('request');
    }

    /**
     * Returns the session component
     * @return HttpSession component
     */
    public function getSession()
    {
        return $this->getComponent('session');
    }
 

    /**
     * Maps application modules
     * @param string $class
     */
    public function mapAppModule($class)
    {
        return isset(self::$_appModules[strtolower($class)]) ? self::$_appModules[strtolower($class)] : '';
    }

    /**
     * Registers the core application components
     * @see setComponent
     */
    protected function registerCoreComponents()
    {
        foreach (self::$_coreComponents as $id => $component)
        {
            $this->setComponent($id, $component);
        }
    }

}
