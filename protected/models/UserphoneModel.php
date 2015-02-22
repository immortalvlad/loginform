<?php

/**
 * Description of UserEntityModel
 *
 * @author immortalvlad
 */
class UserphoneModel extends Model {

    protected $tableName = "user_phone";
    protected static $_instance;

    private function __construct()
    {
        $this->mainModel();
    }

    public function rules()
    {
        return array(
                  // array('', 'required'),
        );
    }

    public function attributeLabels()
    {
        return array(
                $this->tableName => array(
                        'value' => App::app()->t("phone_value"),
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
