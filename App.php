<?php

/**
 * App bootstrap file
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
            'DB' => 'core/DB.php',
            'Model' => 'core/Model.php',
            'Config' => 'components/Config.php',
            'InputRequest' => 'components/InputRequest.php',
            'Form' => 'components/Form.php',
            'HTML' => 'components/HTML.php',
            'Token' => 'components/Token.php',
            'Auth' => 'components/Auth.php',
            'AuthState' => 'components/AuthState.php',
            'Hash' => 'components/Hash.php',
            'Captcha' => 'components/Captcha.php',
            'View' => 'core/View.php',
            'Router' => 'core/Router.php',
            'Filter' => 'helpers/Filter.php',
            'Helper' => 'helpers/Helper.php',
            'Widget' => 'helpers/Widget.php',
            'Mail' => 'helpers/Mail.php',
            'Message' => 'helpers/Message.php',
            'Translate' => 'helpers/Translate.php',
            'Controller' => 'core/Controller.php',
            'Language' => 'core/Language.php',
            'Session' => 'core/Session.php',
    );

    /**
     * All this classes run after init App.  
     * @var array */
    private static $_coreComponents = array(
            'Session' => 'Session',
            'Language' => 'Language',
            'InputRequest' => 'InputRequest',
            'Auth' => 'Auth',
            'AuthState' => 'AuthState'
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
            ini_set('error_log', APP_PATH . DS . 'protect' . DS . 'tmp' . DS . 'logs' . DS . 'error.log');
        }

        // register framework core components
        $this->registerCoreComponents();

        // load view
        $this->view = new View();
        //$this->view->setTemplate(Config::get('defaultTemplate'));

        $router = Router::init();
        $router->route($this);
    }

    /**
     * Class init constructor
     * @param array $config
     * @return App
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
     * @return App
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
    {   //user namespaces
        if (strpos($className, '\\'))
        {
            $className = ltrim($className, '\\');
            $fileName = '';
            $namespace = '';
            if ($lastNsPos = strrpos($className, '\\'))
            {
                $namespace = substr($className, 0, $lastNsPos);
                $className = substr($className, $lastNsPos + 1);
                $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
            }
            $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

            require $fileName;
        }
        //use core
        else if (isset(self::$_coreClasses[$className]))
        {
            // use include so the error PHP file may appear
            include(dirname(__FILE__) . DS . self::$_coreClasses[$className]);
        }
        ///use map
        else
        {
            $classNameItems = preg_split('/(?=[A-Z])/', $className);
            //print_r($classNameItems);

            if (isset($classNameItems[2]) && isset(self::$_classMap[$classNameItems[2]]))
            {
                $classCoreDir = APP_PATH . DS . 'protect' . DS . self::$_classMap[$classNameItems[2]];

                $classFile = $classCoreDir . DS . $className . '.php';
                if (is_file($classFile))
                {
                    require_once $classFile;
                }
            }
        }
    }

    public function t($key)
    {

        return Translate::t($key);
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
     * Returns the request component
     * @return InputRequest component
     */
    public function getRequest()
    {
        return $this->getComponent('InputRequest');
    }

    /**
     * Returns the Language class
     * @return Language class
     */
    public function getLanguage()
    {
        return $this->getComponent('Language');
    }

    /**
     * Returns the Session class
     * @return Session class
     */
    public function getSession()
    {
        return $this->getComponent('Session');
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
