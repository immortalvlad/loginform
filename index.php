<?php
	  

// change the following paths if necessary
defined('APPHP_PATH') || define('APP_PATH', dirname(__FILE__));
// directory separator
defined('DS') || define('DS', DIRECTORY_SEPARATOR);

$apphp = 'App.php';
//$apphp = dirname(__FILE__).'/../../framework/Apphp.php';
$config = APP_PATH.'/protected/config/';
define('APPHP_MODE', 'debug');
          
require_once($apphp);
App::init($config)->run();
