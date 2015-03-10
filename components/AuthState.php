<?php

use components\Auth;

/**
 * Description of AuthState
 *
 * @author immortalvlad
 */
/*
 * AuthState::init()->login();
 * AuthState::init()->logout();
 */
class AuthState {

    protected $_loggedState;
    protected $_notLoggedState;

    /**
     * State
     * @var Auth\IAuthState $_curState  
     */
    private $_curState;
    private $_db;
    private $_sessionName;
    private $_cookieName;
    private $_data;
    private static $_instance = null;

    private function __construct()
    {
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session_name');
        $this->_cookieName = Config::get('cookie_name');

        $this->_loggedState = new Auth\LoggedState($this);
        $this->_notLoggedState = new Auth\NotLoggedState($this);

        $this->check();
    }

    public function check()
    {
        if (!Session::init()->isExists($this->_sessionName) && Session::init()->isCookieExists($this->_cookieName))
        {
            $hash = Session::init()->getCookie($this->_cookieName);
            $modelhash = UsersessionModel::model()->find('hash', $hash);

            if (!empty($modelhash))
            {
                if ($this->checkIp($modelhash[0]['ip']))
                {
                    $user_id = $modelhash[0]['user_entity_id'];
                    $find_user = $this->findUserById($user_id);
                    $this->setSession();
                    $find_user ? $this->_curState = $this->_loggedState : $this->_curState = $this->_notLoggedState;
                } else
                {
                    $this->_curState = $this->_notLoggedState;
                }
            } else
            {
                $this->_curState = $this->_notLoggedState;
            }
        } else
        if (Session::init()->isExists($this->_sessionName))
        {
            $this->_curState = $this->_loggedState;
        } else
        {
            $this->_curState = $this->_notLoggedState;
        }
    }

    public function login($username = '', $password = '', $remember = false)
    {
         $this->_curState->loggedIn($username, $password, $remember);
         return $this->_curState->islogged();
    }

    public function islogged()
    {
//        echo get_class($this->getCurState());
        return $this->_curState->islogged();
    }

    public function findUserByName($username)
    {
        $data = UserModel::model()->find('username', $username);
        if ($data)
        {
            $this->_data = $data;
            return true;
        }
        return false;
    }

    public function checkIp($ip)
    {
        return $ip == $_SERVER["REMOTE_ADDR"] ? true : false;
    }

    public function findUserById($id)
    {
        $data = UserModel::model()->selectById($id);
        if ($data)
        {
            $this->_data = $data;
            return true;
        }
        return false;
    }

    public function logout()
    {
        $this->_curState->loggedOut();
    }

    public function setState(Auth\IAuthState $state)
    {
        $this->_curState = $state;
    }

    public function getCurState()
    {
        return $this->_curState;
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

    public function getLoggedState()
    {
        return $this->_loggedState;
    }

    public function getNotLoggedState()
    {
        return $this->_notLoggedState;
    }

    public function getData()
    {
        $sessionName = Session::init()->get($this->_sessionName);
        if (!empty($this->_data[0]))
        {
            return $this->_data[0];
        } elseif (!empty($sessionName))
        {
            $this->_data[0] = Session::init()->get($this->_sessionName);
            return $this->_data[0];
        } else
        {
            return false;
        }
    }

    public function endSession()
    {
        Session::init()->deleteSession($this->_sessionName);
        Session::init()->deleteCookie($this->_cookieName);
    }

    public function setSession()
    {
        if ($this->getData())
        {
            //Set User data in Session
            Session::init()->set($this->_sessionName, $this->getData());
            return true;
        }
        return false;
    }

    public function setCookie($hash)
    {
        Session::init()->setCookie(Config::get('cookie_name'), $hash, Config::get('cookie_expiry'));
    }

}
