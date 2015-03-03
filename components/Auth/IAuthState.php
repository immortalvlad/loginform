<?php

namespace components\Auth;

/**
 *
 * @author immortalvlad
 */
interface IAuthState {

   function loggedIn();
   function loggedOut();
   function islogged();
}
