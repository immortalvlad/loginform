<?php

class DB {

    private $DB_DRIVER;
    private $DB_HOST;
    private $DB_NAME;
    private $DB_USER;
    private $DB_PASS;
    private $db;
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

}
