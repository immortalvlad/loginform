<?php

/**
 * Description of Auth
 *
 * @author immortalvlad
 */
class Auth {

    private $_db;
    private $_data;
    private $_sessionName;
    private $_cookieName;
    private $_isLoggedIn;
    private static $_instance;

    private function __construct()
    {
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session_name');
        $this->_cookieName = Config::get('cookie_name');

//        if (!$user)
//        {
//            if (Session::exists($this->_sessionName))
//            {
//                $user = Session::get($this->_sessionName);
//                if ($this->find($user))
//                {
//                    $this->_isLoggedIn = true;
//                } else
//                {
//                    
//                }
//            }
//        } else
//        {
//            $this->find($user);
//        }
    }

    /**
     * Initializes the component
     * @return self 
     */
    public static function init()
    {
        if (self::$_instance == null)
            self::$_instance = new self();
        return self::$_instance;
        
       
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

    public function login($username = null, $password = null, $remember = false)
    {

        if (!$username && !$password && $this->exists())
        {
//            Session::put($this->_sessionName, $this->_data->id);
        } else
        {
            $user = $this->findUserByName($username);

            if ($user)
            {                
                if ($this->_data[0]["password"] === $password)
//                if ($this->_data->password === Hash::make($password, $this->_data->salt))
                {
                    Session::init()->set($this->_sessionName, $this->_data[0][UserModel::model()->getPK()]);
//
//                    if ($remember)
//                    {
//                        $hash = Hash::unique();
//                        $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->_data->id));
//
//                        if (!$hashCheck->count())
//                        {
//                            $this->_db->insert('users_session', array(
//                                    'user_id' => $this->_data->id,
//                                    'hash' => $hash,
//                            ));
//                        } else
//                        {
//                            $hash = $hashCheck->first()->hash;
//                        }
//                        Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
//                    }
                    return true;
                }
            }
        }
        return false;
    }

    public function exists()
    {
        return (!empty($this->_data)) ? true : false;
    }

}
