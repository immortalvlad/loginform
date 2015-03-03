<?php
class DB {

    private $DB_DRIVER;
    private $DB_HOST;
    private $DB_NAME;
    private $DB_USER;
    private $DB_PASS;
   /**
    *
    * @var PDO 
    */
    private $db;
    private $_errorLog;
    private $prfx = '';
    private $test_rec = false;
    private static $_instance;

    private function __construct()
    {
       
        $this->DB_DRIVER = Config::get("DB_DRIVER");
        $this->DB_HOST = Config::get("DB_HOST");
        $this->DB_NAME = Config::get("DB_NAME");
        $this->DB_USER = Config::get("DB_USER");
        $this->DB_PASS = Config::get("DB_PASS");

        $this->conect();
    }

    private function __clone()
    {
        
    }

    /**
     * Singleton
     * @return self
     */
    public static function getInstance()
    {
        if (null === self::$_instance)
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 
     * @return PDO
     */
    public function getConnection()
    {
        return $this->db;
    }

    public function lastInsertId()
    {
         
        return $this->db->lastInsertId();
    }

    public function getPrefix()
    {
        return $this->prfx;
    }

    /**
     * connection to the database
     */
    public function conect()
    {
        try
        {
            $connect_str = $this->DB_DRIVER . ':host=' . $this->DB_HOST . ';dbname=' . $this->DB_NAME;
            $this->db = new PDO($connect_str, $this->DB_USER, $this->DB_PASS);

            $error_array = $this->db->errorInfo();

            if ($this->db->errorCode() != 0000)
            {
                //error
            }
        } catch (PDOException $e)
        {
            die("Error: " . $e->getMessage());
        }
    }

    public function getError()
    {
        return $this->_errorLog;
    }

    /**
     * Execute query
     * Return array or false if nothing to be found
     * @param type $sql
     * @param type $params
     * @return array | false
     */
    public function query($sql, $params = array(), $insert = '')
    {
        /* @var $query PDOStatement */
        if ($query = $this->db->prepare($sql))
        {
            $x = 1;
            if (count($params))
            {
                foreach ($params as &$param)
                {
                    $query->bindParam($x, $param);
                    $x++;
                }
            }
            try
            {
                if ($query->execute())
                {
                    if ($insert == "insert")
                    {
                        return $this->db->lastInsertId();
                    } else
                    {
                        $results = $query->fetchAll(PDO::FETCH_ASSOC);
                        if (empty($results))
                        {
                            $results = FALSE;
                        }
                    }
                } else
                {
                    $results = FALSE;
                }
            } catch (PDOException $e)
            {
                $this->_errorLog = 'insert [ ln.:' . $e->getLine() . ']' . $e->getMessage() . ' => ' . $sql;
                return false;
            }
        }
        return $results;
    }

}
