<?php

/**
 *  UserEntityModel
 *
 * @author immortalvlad
 */
class UserrecoverModel extends Model {

    protected $tableName = "user_recover";
    protected $_primaryKey = 'user_recover_id';
    protected static $_instance;
    protected $rules = array();

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
