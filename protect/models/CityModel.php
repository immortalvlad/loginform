<?php

/**
 * Description of UserEntityModel
 *
 * @author immortalvlad
 */
class CityModel extends Model {

    protected $tableName = "city";
    protected $_primaryKey = 'id';
    protected static $_instance;

    private function __construct()
    {
        $this->mainModel();
    }

    public function rules()
    {
        return array(
                $this->tableName => array(
                     
                )
        );
    }

    public function attributeLabels()
    {
        return array(
                $this->tableName => array(
                       
                )
        );
    }

    /**
     * 
     * @return self
     */
    public static function model()
    {
        if (null === self::$_instance)
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

}
