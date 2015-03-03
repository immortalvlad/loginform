<?php

/**
 * Description of UserEntityModel
 *
 * @author immortalvlad
 */
class UseraddressModel extends Model {

    protected $tableName = "user_address";
    protected $_primaryKey = 'user_address_id';
    protected static $_instance;

    private function __construct()
    {
        $this->mainModel();
    }

    public function rules()
    {
        return array(
                $this->tableName => array(
                        "country_id" => array(
//                                'required' => true,
                        ),
                        "city_id" => array(
//                                'required' => true,
                        )
                )
        );
    }

    public function attributeLabels()
    {
        return array(
                $this->tableName => array(
                        'country_id' => App::app()->t("country_id"),
                        'city_id' => App::app()->t("city_id"),
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
