<?php

/**
 *  UserEntityModel
 *
 * @author immortalvlad
 */
class UsersessionModel extends Model {

    protected $tableName = "user_session";
    protected $_primaryKey = 'id';
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
                        "user_entity_id" => array(
                                'required' => true
                        ),
                        "hash" => array(
                                'required' => true,
                        )
                )
        );
    }

    public function attributeLabels()
    {
        return array(
                $this->tableName => array(
                        'user_entity_id' => App::app()->t("user_entity_id"),
                        'hash' => App::app()->t("hash"),
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
