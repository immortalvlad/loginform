<?php

namespace components\Auth;

/**
 * Description of LoggedState
 *
 * @author immortalvlad
 */
class LoggedState implements IAuthState {

    private $_state;

    public function __construct(\AuthState $state)
    {
        $this->_state = $state;
    }

    public function loggedIn()
    {
        echo "Вы уже зарегестрированы<br>";
        return true;
    }

    public function loggedOut()
    {   
        $this->_state->endSession();
        $this->_state->setState($this->_state->getNotLoggedState());
    }

    public function islogged()
    {
//        echo "Залогинен";
        return true;
    }

}
