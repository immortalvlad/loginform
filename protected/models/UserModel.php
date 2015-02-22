<?php

/**
 * Description of UserEntityModel
 *
 * @author immortalvlad
 */
class UserModel extends Model {

    protected $tableName = "user_entity";
    protected static $_instance;

    private function __construct()
    {
        $this->mainModel();
    }

    public function rules()
    {
        return array(
                // username and password are required
                array('email, password', 'required'),
        );
    }

    public function attributeLabels()
    {
        return array(
                $this->tableName => array(
                        'email' => App::app()->t("email"),
                        'password' => App::app()->t("password"),
                        'date_added' => App::app()->t("date_added"),
                        'status' => App::app()->t("status"),
                        'first_name' => App::app()->t("first_name"),
                        'last_name' => App::app()->t("last_name"),
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
