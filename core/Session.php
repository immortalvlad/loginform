<?php

/**
 * provides work with  session
 *
 * @author immortalvlad
 */
class Session {

    /** @var object */
    private static $_instance;

    /** @var string */
    private $_defaultSessionName = 'app_framework';

    /** @var string */
    private $_defaultSessionPrefix = 'app_';

    /**
     * @var int
     */
    private $_prefix = '';
    private $cookiesLifeTime = 1;
    private $_cookiesLifeTime;
    /**
     * @var string
     * only | allow | none
     */
    private $_cookieMode = 'only';

    public function __construct()
    {
        $this->setCookiesLifeTime();
        
        $this->setCookieMode($this->_cookieMode);

        $this->setSessionName();

        $this->openSession();
    }

    /**
     * Initializes the session component
     * @return self 
     */
    public static function init()
    {
        if (self::$_instance == null)
            self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * Sets session variable 
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Returns session variable 
     * @param string $name
     * @param mixed $default
     */
    public function get($name, $default = '')
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : $default;
    }

    private function setCookiesLifeTime()
    {
        return $this->_cookiesLifeTime = time() + 60 * 60 * 24 * $this->cookiesLifeTime;
    }

    private function getCookiesLifeTime()
    {
        return isset($this->_cookiesLifeTime) ? $this->_cookiesLifeTime : 0;
    }

    /**
     * Sets Cookie variable 
     * @param string $name
     * @param mixed $value
     */
    public function setCookie($name, $value)
    {
        setcookie($name, $value, $this->getCookiesLifeTime(),"/");
    }

    /**
     * Returns Cookie variable 
     * @param string $name
     * @param mixed $default
     */
    public function getCookie($name, $default = '')
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $default;
    }

    /**
     * Checks if session variable exists
     * @param string $name
     */
    public function isExists($name)
    {
        return isset($_SESSION[$name]) ? true : false;
    }

    /**
     * Sets session name
     * @param string $value
     */
    public function setSessionName($value = '')
    {
        if (empty($value))
            $value = $this->_defaultSessionName;
        session_name($value);
    }

    /**
     * Gets session name
     * @return string 
     */
    public function getSessionName()
    {
        return session_name();
    }

    /**
     * Gets session id
     * @return string 
     */
    public function getSessionId()
    {
        return session_id();
    }

    /**
     * Destroys the session
     */
    public function endSession()
    {
        if (session_id() !== '')
        {
            @session_unset();
            @session_destroy();
        }
    }

    /**
     * Gets cookie mode
     * @return string
     */
    public function getCookieMode()
    {
        if (ini_get('session.use_cookies') === '0')
        {
            return 'none';
        } else if (ini_get('session.use_only_cookies') === '0')
        {
            return 'allow';
        } else
        {
            return 'only';
        }
    }

    /**
     * Starts the session if it has not started yet
     */
    private function openSession()
    {
        @session_start();
    }

    /**
     * Sets cookie mode
     * @value string
     */
    private function setCookieMode($value)
    {
        switch ($value)
        {
            case 'none':
                ini_set('session.use_cookies', '0');
                ini_set('session.use_only_cookies', '0');
                break;
            case 'allow':
                ini_set('session.use_cookies', '1');
                ini_set('session.use_only_cookies', '0');

                break;
            case 'only':
                ini_set('session.use_cookies', '1');
                ini_set('session.use_only_cookies', '1');

                break;
            default:
                break;
        }
    }

}
