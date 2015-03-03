<?php

/**
 * Description of UserEntityModel
 *
 * @author immortalvlad
 */
class SimpleModel extends Model {

    protected $tableName = "model";
    protected $_primaryKey = 'model';
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
