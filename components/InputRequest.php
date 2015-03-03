<?php

/**
 * InputRequest is a default application component loaded by App
 */
class InputRequest {

    /** @var object */
    private static $_instance;

    /**
     * Class default constructor
     */
    function __construct()
    {
        $this->cleanRequest();
    }

    /**
     * 	Returns the instance of object
     * 	@return InputRequest class
     */
    public static function init()
    {
        if (self::$_instance == null)
            self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * Strips slashes from data
     * @param mixed $data input data to be processed
     * @return mixed processed data
     */
    public function stripSlashes(&$data)
    {
        return is_array($data) ? array_map(array($this, 'stripSlashes'), $data) : stripslashes($data);
    }

    /**
     * 	Returns parameter from global array $_GET
     * 	@param string $name
     * 	@param string|array $filters
     * 	@param string $default
     * 	@return mixed
     */
    public static function getQuery($name, $filters = '', $default = '')
    {
        return self::init()->getParam('get', $name, $filters, $default);
    }

    /**
     * 	Returns parameter from global array $_POST
     * 	@param string $name
     * 	@param string|array $filters
     * 	@param string $default
     * 	@return mixed
     */
    public static function getPost($name, $filters = '', $default = '')
    {
        return self::init()->getParam('post', $name, $filters, $default);
    }

    /**
     * 	Returns parameter from global array $_GET or $_POST
     * 	@param string $name
     * 	@param string|array $filters
     * 	@param string $default
     * 	@return mixed
     */
    public static function getRequest($name, $filters = '', $default = '')
    {
        return self::init()->getParam('request', $name, $filters, $default);
    }

    /**
     * Returns whether there is a POST request
     * @return boolean 
     */
    public static function IsPostRequest()
    {
        return isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'], 'POST');
    }

    /**
     * Cleans the request data.
     * This method removes slashes from request data if get_magic_quotes_gpc() is turned on
     */
    protected function cleanRequest()
    {
        // clean request
        if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc())
        {
            $_GET = $this->stripSlashes($_GET);
            $_POST = $this->stripSlashes($_POST);
            $_REQUEST = $this->stripSlashes($_REQUEST);
            $_COOKIE = $this->stripSlashes($_COOKIE);
        }
    }


    public static function getFormPost($table, $name, $filters = '', $default = '')
    {
        $value = '';
       
        if (isset($_POST[$table][$name]))
        {
            $value = $_POST[$table][$name];
        }
        if ($value !== '')
        {
            if (!is_array($filters))
                $filters = array($filters);
            foreach ($filters as $filter)
            {   
                $value = is_array($value) ? '': Filter::sanitize($filter, $value);
               
            }
            return $value;
        } else
        {
            return $default;
        }
    }

    /**
     * 
     * @param Model $model
     * @param type $name
     * @param type $filters
     * @param type $default
     * @return type
     */
    public static function getPostModel(Model $model, $name, $filters = '', $default = '')
    {
        $value = '';
        $tableName = $model->getTableName();
        if (isset($_POST[$tableName][$name]))
        {
            $value = $_POST[$tableName][$name];
        }
        if ($value !== '')
        {
            if (!is_array($filters))
                $filters = array($filters);
            foreach ($filters as $filter)
            {
                $value = Filter::sanitize($filter, $value);
            }
            return $value;
        } else
        {
            return $default;
        }
    }

    /**
     * 	Returns parameter from global arrays $_GET or $_POST according to type of request
     * 	@param string $type
     * 	@param string $name
     * 	@param string|array $filters
     * 	@param string $default
     * 	@return mixed
     */
    private function getParam($type = 'get', $name, $filters = '', $default = '')
    {
        $value = '';
        if ($type == 'get' && isset($_GET[$name]))
        {
            $value = $_GET[$name];
        } else if ($type == 'post' && isset($_POST[$name]))
        {
            $value = $_POST[$name];
        } else if ($type == 'request' && (isset($_GET[$name]) || isset($_POST[$name])))
        {
            $value = isset($_GET[$name]) ? $_GET[$name] : $_POST[$name];
        }
        if ($value !== '')
        {
            if (!is_array($filters))
                $filters = array($filters);
            foreach ($filters as $filter)
            {
                $value = Filter::sanitize($filter, $value);
            }
            return $value;
        } else
        {
            return $default;
        }
    }

}
