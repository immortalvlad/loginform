<?php

namespace components\Auth;

/**
 * Description of NotLoggedState
 *
 * @author immortalvlad
 */
class NotLoggedState implements IAuthState {

    private $_state;

    public function __construct(\AuthState $state)
    {
        $this->_state = $state;
    }

    public function loggedIn($username = '', $password = '', $remember = false)
    {
//        echo "Регестрирую<br>";
        $user = $this->_state->findUserByName($username);
        if ($user)
        {
//            if ($this->_state->getData()["password"] === $password)
            if ($this->_state->getData()["password"] === \Hash::make($password, $this->_state->getData()["salt"]))
            {
                $this->_state->setState($this->_state->getLoggedState());

                $this->_state->setSession();
//
                if ($remember)
                {
                    $hash = \Hash::unique();
                    $user_id = $this->_state->getData()[\UserModel::model()->getPK()];
                    $hashCheck = \UsersessionModel::model()->find('user_entity_id', $user_id);

                    if (empty($hashCheck))
                    {
                        \UsersessionModel::model()->insert(array(
                                "user_entity_id" => $user_id,
                                'hash' => $hash,
                                'ip' => !empty($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : ''
                        ));
                    } else
                    {
                        \UsersessionModel::model()->update($hashCheck[0]["id"], array("ip" => $_SERVER["REMOTE_ADDR"],));
                        $hash = $hashCheck[0]["hash"];
                    }
                    $this->_state->setCookie($hash);
                }
//                return true;
            }
        }
//        return false;
    }

    public function loggedOut()
    {
        echo "Вы не зарегены<br>";
    }

    public function islogged()
    {
//          echo "Вы не зарегены<br>";
        return false;
    }

}
