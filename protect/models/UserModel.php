<?php

/**
 *  UserEntityModel
 *
 * @author immortalvlad
 */
class UserModel extends Model {

    protected $tableName = "user_entity";
    protected $_primaryKey = 'user_entity_id';
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
                        "email" => array(
                                'required' => true,
                                'type' => 'email',
                                'min' => 2,
                                'max' => 20,
                                'unique' => $this
                        ),
                        "username" => array(
                                'required' => true,
                                'min' => 2,
                                'max' => 20,
                                'unique' => $this
                        ),
                        "telephone" => array(
                                'min' => 6,
                                'max' => 10,
                        ),
                        "password" => array(
                                'required' => true,
                                'min' => 6,
                        ),
                        "password_again" => array(
                                'required' => true,
                                'matches' => 'password',
                        )
                )
        );
    }

    public function attributeLabels()
    {
        return array(
                $this->tableName => array(
                        'username' => App::app()->t("username"),
                        'email' => App::app()->t("email"),
                        'password' => App::app()->t("password"),
                        'password_again' => App::app()->t("password_again"),
                        'telephone' => App::app()->t("telephone"),
                        'date_added' => App::app()->t("date_added"),
                        'status' => App::app()->t("status"),
                        'first_name' => App::app()->t("first_name"),
                        'last_name' => App::app()->t("last_name"),
                        'salt' => App::app()->t("salt"),
                        'loged_id' => App::app()->t("loged_id"),
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
