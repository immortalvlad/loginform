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
                                'min' => 6,
                                'max' => 50,
                                'unique' => $this
                        ),
                        "username" => array(
                                'required' => true,
                                'type' => 'login',
                                'min' => 5,
                                'max' => 20,
                                'unique' => $this
                        ),
                        "telephone" => array(
                                'type' => 'phone',
                                'min' => 6,
                                'max' => 20,
                        ),
                        "password" => array(
                                'required' => true,
                                'min' => 6,
                        ),
                        "password_again" => array(
                                'required' => true,
                                'min' => 6,
                                'matches' => 'password',
                        ),
                        "first_name" => array(
                                'type' => 'login',
                        ),
                        "last_name" => array(
                                'type' => 'login',
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
